<?php
class CssParser{
  var $contents = '';
  var $header = '';
  var $media = '';
  var $classArray = array();
  var $configArray = array();
  var $fileToParse = '';
  var $fileBackup = '';
  var $folder = '';
  var $url = '';
  var $imports = array();
  var $urlCssSubmenu = '@import url("/modules/slider/assets/css/multilevelmenu.css");';
  //var $this->urlCssSubmenu = '@import url("' . XOOPS_URL . '/modules/slider/assets/css/multilevelmenu.css");';


    
/* ***********************
Constructeur
************************** */
  function __construct($fileToParse, $reloadOldFile = false) {
//  echo "<hr>===>file<br>{$fileToParse}";    
    $this->fileToParse = $fileToParse;
    $this->folder = dirname($fileToParse);  
    $this->url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $this->folder);  
    $this->fileBackup = str_replace('.css','-old.css', $fileToParse);
    //----------------------------------------
    if (is_readable($fileToParse)){
      //une tite backup au cas ou
      if (!is_readable($this->fileBackup)) copy ($fileToParse, $this->fileBackup);
    }else{
         $reloadOldFile = true;
    }
    if($reloadOldFile) $this->restaure();        
    
    return true;
  }
  
/* ***********************

************************** */
function restaure(){
    copy($this->fileBackup, $this->fileToParse);
}

/* ***********************
Read the css
************************** */
function parse($searchHeader='', $searchFooter=''){

    $contents = file_get_contents($this->fileToParse);
    $h = ($searchHeader) ? strpos($contents, $searchHeader) : 0;
    $j = ($searchFooter) ? strpos($contents, $searchFooter, $h) : 0;
    
    if ($h > 0) $this->header = substr($contents, 0, $h);
    if ($j > 0) $this->media  = substr($contents, $j);
    
$this->extract_imports($contents);  
    //echo "===>header<hr>{$this->header}<hr>";
    $cssContents = ($j > 0) ? substr($contents, $h, $j-$h) : substr($contents, $h);

    $cssContents = str_replace("\n",'',$cssContents);
    $cssContents = str_replace("\r",'',$cssContents);
    //echo "<hr>===>contents<br>{$contents}";
    $this->contents = $cssContents;

//     echo "<hr>===>header<br>{$this->header}";
//     echo "<hr>===>CSS<br>{$this->contents}<hr>";
        //-------------------------------------------------------------------    
    
    $class = explode('}', $this->contents);
    $this->classArray = array();
    foreach($class AS $key=>$value){
        $h = strpos($value, '{');
        $name = trim(substr($value, 0, $h));
        if(!$name) continue;
        $contents = trim(substr($value, $h+1));
        //echo "===>{$name}<br>{$contents}<br><br>";
        
        $att = $this->parse_attributes($contents);
        if(isset($this->classArray[$name])){
            $this->classArray[$name] = array_merge($this->classArray[$name], $att);
        }else{
            $this->classArray[$name] = $att;
        }
    
    
        //$this->classArray[$name] = $value; //trim(substr($value, $h+1));
    }
    $this->get_attributes2update();
}
    

/* ***********************

************************** */
    function parse_attributes($contents){
        $ta = explode(';', $contents);
       // echo "+++===><br>{$contents}<br><br>";
        
        $attributesArray = array();
        foreach($ta AS $key=>$value){
            if(trim($value) !=''){ 
              $h = strpos($value, ':');
              $name = trim(substr($value, 0, $h));
              $attributesArray[$name] = trim(substr($value, $h+1));
            }else{
            }
        }
        return $attributesArray;
    }
    
/* ***********************

************************** */
function extract_imports(&$contents){
    
//    $h =  stripos($contents, "@import");
        $j = strpos($contents, ';', $h);
//echo "<hr>{$h} - {$j}<hr>";
    
    while (($h = stripos($contents, "@import")) !== false){
//echo "<hr>{$h} - {$j}<hr>";
        $j = strpos($contents, ';', $h);
        $import = substr($contents, $h, $j - $h +1);
        $this->imports[] = $import;
        $contents = str_replace($import,"", $contents);
//    $h =  stripos($contents, "@import");
    }  
//echo "<hr>Imports URL : {$import}<pre>" . print_r($this->imports, true ). "</pre><hr>";
//echo "===>" . $contents;
//exit("zzzzzzzzzzzzz");  
    
    return count($this->imports);
}

/* ***********************
recupere le fichier de config et affecte à chaque attribut les valeurs du css chargé.
************************** */
function get_attributes2update(){
    $f = '../include/config-my_xoops-css.php';
    if(file_exists($f)){
    //echo "<hr>get_attributes2update{$f}<hr>";
        include_once ($f);
        foreach($config AS $keyClass=>$class){
            foreach($class AS $keyAttrinute=>$attribute){
            //$cssArray[$key]['value'] = $css->getAttribute($delim['class'], $delim['attribute'], $delim['default']);
                $config[$keyClass][$keyAttrinute]['value'] = $this->getAttribute($keyClass,  $keyAttrinute, $attribute['default']);
            }    
        }
//        sld_echoArray($config);
    }else{
        $config = array();
    }
    $this->configArray = $config;
    return $config; 
}
    
    
/* ***********************

************************** */
function get_explodeAtt($exp, $type=''){

      switch($type){
      case 'file':
      case 'linear2':
          $h = strpos($exp, '(');
          $i = strpos($exp, ')');
          $ret = substr($exp, $h+1, $i-$h-1);
          $ret = str_replace(array("\"","'"),'', $ret);
          break;
          
      case 'linear':
          $h = strpos($exp, '(');
          $i = strpos($exp, ')');
          $expExtract = substr($exp, $h+1, $i-$h-1);
          $expExtract = str_replace(array("\"","'"),'', $expExtract);
          $tColors = explode(',', $expExtract);
          $ret = array();
          for ($h = 0; $h < count($tColors); $h++){
            $t = explode(' ', $tColors[$h]);
            $ret[] = trim($t[0]);
          }
          //sld_echoArray($ret, $expExtract);
          break;
          
      case 'color':
      default:
          $ret = $exp;
          break;
      }
      
      return $ret;        
}

/* ***********************

************************** */
function get_implodeAtt($exp, $type){

    switch($type){
    case 'file':
        $ret = "url(\"{$exp}\")";
        break;
        
    case 'linear':
        $ret = "linear-gradient({$exp[0]},{$exp[1]} 60%,{$exp[2]})";
        break;
        
    case 'color':
    default:
        $ret = $exp;
        break;
    }
    return $ret;
}


/* ***********************

************************** */
function getAttribute($keyClass, $keyAttribute, $default = ''){
    if (isset($this->classArray[$keyClass][$keyAttribute])){
        return $this->classArray[$keyClass][$keyAttribute];
    }else{
        return $default;
    }
}
/* ***********************

************************** */
function setAttribute($keyClass, $keyAttribute, $newValue){
    $this->classArray[$keyClass][$keyAttribute] = $newValue;
}
    
/* ***********************

************************** */

    
    function getArray(){
        return $this->classArray;
    }
    
/* ***********************

************************** */
function saveNewAttribute($newCssAttributes, $minify = true, $force = false){
    //$this->$classArray=$newCssAttributes;
    $bolOk = false;
    foreach($newCssAttributes AS $keyClass=>$class){
        foreach($class AS $keyAttrinute=>$attribute){
            $newValue = $this->get_implodeAtt($attribute, $this->configArray[$keyClass][$keyAttrinute]['type']);
            
            
          if($this->getAttribute($keyClass, $keyAttrinute) != $newValue){
                $this->classArray[$keyClass][$keyAttrinute] = $newValue;
                $bolOk = true;
            }

        
//             
//               if($this->classArray[$keyClass][$keyAttrinute] ;
//                 $this->classArray[$keyClass][$keyAttrinute] = $attribute;
//                 $bolOk = true;
        }    
    }
    
        //pour des tests
        //$this->classArray['body']['background-color'] = 'yellow';
        
        if($bolOk || $force)  $this->saveCss($minify);      
        
    }
    
    
/* ***********************

************************** */
function saveCss($minify = true){
    $contents = ($minify) ? $this->saveCss_minify() : $this->saveCss_array() ;
    file_put_contents ($this->fileToParse, $contents, LOCK_EX );  
}
    
/* ***********************

************************** */
function saveCss_array(){
    $cssArr = array();
    if ($this->header !='') $cssArr[] = $this->header;
    $bolOk = true;
    
    if (count($this->imports) > 0) {
        for ($h = 0; $h< count($this->imports); $h++){
            $cssArr[] = $this->imports[$h];
            if(trim($this->imports[$h]) == $this->urlCssSubmenu) $bolOk = false;
        }
        $cssArr[] = '';
    }
    if ($bolOk) $cssArr[] = $this->urlCssSubmenu;
    //------------------------------------------------------
    $indent = '    ';
    $sep = "\n";
    foreach($this->classArray AS $keyClass=>$class){
        $cssArr[] = $keyClass . "{";
        foreach($class AS $keyAttrinute=>$value){
            $cssArr[] = "{$indent}{$keyAttrinute}:{$value};";
        }
        $cssArr[] = "}";
    }

    //------------------------------------------------------
    if ($this->media !='') $cssArr[] = $this->media;

    $css = implode($sep, $cssArr);
    return $css;  
    
    
}
/* ***********************

************************** */
function saveCss_minify(){
    $cssArr = array();
    if ($this->header !='') $cssArr[] = $this->header;
    
    //------------------------------------
    if (count($this->imports) > 0) {
        for ($h = 0; $h< count($this->imports); $h++){
            $cssArr[] = $this->imports[$h];
            if(trim($this->imports[$h]) == $this->urlCssSubmenu) $bolOk = false;
        }
        $cssArr[] = '';
    }
    if ($bolOk) $cssArr[] = $this->urlCssSubmenu;
    //------------------------------------------------------
    $sep = '';
    foreach($this->classArray AS $keyClass=>$class){
        $cssArr[] = $keyClass . "{";
        foreach($class AS $keyAttrinute=>$value){
            $cssArr[] = "{$keyAttrinute}:{$value};";
        }
        $cssArr[] = "}";
    }
    
    if ($this->media !='') $cssArr[] = $this->media;
    
    $css = implode($sep, $cssArr);
    $css = str_replace(';}', '}', $css);
   return $css;  
   
}
    
/* ***********************

************************** */
function toString(){
    $ret =  "<div style='color:green;'>===>CSS<pre>"
         . print_r($this->classArray, true)
         . "</pre></div>";
    return $ret;
}
} // Fin de la classe