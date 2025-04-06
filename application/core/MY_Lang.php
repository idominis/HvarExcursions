<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

// Originaly CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// modification by Yeb Reitsma

/*
in case you use it with the HMVC modular extension
uncomment this and remove the other lines
load the MX_Loader class */

//require APPPATH."third_party/MX/Lang.php";

//class MY_Lang extends MX_Lang {

/*

DOCUMENTATION:
  - Do not forget to write routes.php: $route['^(en|hr)/(.+)$'] = '$2'; $route['^(en|hr)$'] = default
  - MY_Language_helper isn't required for this lib to work
  - lang file can contain something like this:
    $lang['welcome'] = "Welcome, %s.";
  - Use it like this:
    lang('welcome', $username)
  - Also, if you supply second argument=id to lang(), it will wrapp it by <label for="id">.. 
  - To create ANCHOR containing the current language:
    use normal anchor, anchor('music','Shania Twain') ---> ALWAYS USE ANCHORS FOR SEO!
  - Links to internal pages are prefixed by the current language, but links to files are not
    site_url('about/my_work'); // http://mywebsite.com/en/about/my_work
    site_url('css/styles.css'); // http://mywebsite.com/css/styles.css
    site_url('/'); will append language code to base_url while site_url() will not
  - Get the current language:
    $this->lang->lang();
  - Switch to another language:
    anchor($this->lang->switch_uri('fr'),'Display current page in French');
  - Switch language in between of rendering:
    $this->lang->is_loaded = array(); $this->lang->language = array();

  - HRVOJE 03.12.2013. 302 => 301 redirect changed
  - HRVOJE 03.12.2013. For SEO purposes, there will be no more URL's without second segment (so alwasys if there is lang, there has to be another argument as well, not only lang)
  - HRVOJE 11.05.2014. All the configuration moved to $config file now
  - HRVOJE 11.05.2014. If URL is special, it shouldn't have language code
  - HRVOJE 11.05.2014. Fix for switch_uri() if special URI
  - HRVOJE 19.05.2019. Fully refactored MY_language_helper.php. One could now use vsprintf() and label generation is removed

  - SEO prednosti:
  - samo jedan URL za jednu stranicu, dakle nema da je example.com isto ko i example.com/index i sl...
  - nek se uvijek redirecta na defaultni URL npr na en/ tako da u SEO-u 301 uvijek bude isti
  - URL-ovi su intuitivni, dakle ako se prebriše neki dio URL-a nije problem rekonstruirati akciju
  - obavezno sve multijezicne stranice oznaci sa rel=alternative hreflang=xx, ili naravno da budu i kanonicke

*/
 
class MY_Lang extends CI_Lang {


  /**************************************************
   configuration
  ***************************************************/
 
  // languages
  // the first will be default, anyway it is affected by HTTP_ACCEPT_LANGUAGE
  private $languages;
 
  // special URIs (not localized)
  // The root URI (/) is by default a special URI, which won't be prefixed language
  private $special;
  
  // where to redirect if no language in URI
  private $uri;
  private $default_uri;
  private $lang_code;
 
  /**************************************************/
    
    
  function __construct()
  {
    parent::__construct();
    
    global $CFG;
    global $URI;
    global $RTR;

    // 11.05.2014. HRVOJE load configuration from config.php file
    $this->special = $CFG->item('multilang_URIs');
    $this->languages = $CFG->item('languages');
    
    $this->uri = $URI->uri_string();
    $this->default_uri = $RTR->default_controller;
    
    $uri_segment = $this->get_uri_lang($this->uri);
    $this->lang_code = $uri_segment['lang'];

    $url_ok = false;

    // lang code in URI
    if ((!empty($this->lang_code)) && (array_key_exists($this->lang_code, $this->languages)))
    {
        // HRVOJE 11.05.2014. - if this is special URL, it shouldn't have language code
        if($this->is_special($URI->segment(2))){
          array_shift($uri_segment['parts']); // remove lang
          $uri = implode('/', $uri_segment['parts']); 
          $index_url = empty($CFG->config['index_page']) ? '' : $CFG->config['index_page']."/";
          $new_url = $CFG->config['base_url'].$index_url.$uri;
          
          header("Location: " . $new_url, TRUE, 301); /* HRVOJE 03.12.2013. 302 => 301 */
          exit;
        }

        // HRVOJE 03.12.2013. Do not allow url's with no second segment (for example only /en), for SEO purpouses
        if(!$URI->segment(2)){ 
          
          // copied from downthere, unless it's special URI
          $uri = $this->default_uri;
          $index_url = empty($CFG->config['index_page']) ? '' : $CFG->config['index_page']."/";
          $new_url = $CFG->config['base_url'].$index_url.$this->lang_code.'/'.$uri;
          header("Location: " . $new_url, TRUE, 301);
          exit;
          
        }
        else
        {
          $language = $this->languages[$this->lang_code];
          $CFG->set_item('language', $language);
          $url_ok = true;
        }
        
    } 
      
    // no lang code in URI, redirect to default language==user agent!
    if ((!$url_ok) && (!$this->is_special($uri_segment['parts'][0]))) // special URI -> no redirect
    { 
      // set default language
      $CFG->set_item('language', $this->languages[$this->default_lang()]);
      
      $uri = (!empty($this->uri)) ? $this->uri: $this->default_uri;
      //OPB - modification to use i18n also without changing the .htaccess (without pretty url) 
      $index_url = empty($CFG->config['index_page']) ? '' : $CFG->config['index_page']."/";
      $new_url = $CFG->config['base_url'].$index_url.$this->default_lang().'/'.$uri;
      
      header("Location: " . $new_url, TRUE, 301); /* HRVOJE 03.12.2013. 302 => 301 */
      exit;
    }
  }


    
  // get current language
  // ex: return 'en' if language in CI config is 'english' 
  function lang()
  {
    global $CFG;        
    $language = $CFG->item('language');
    
    $lang = array_search($language, $this->languages);
    if ($lang)
    {
      return $lang;
    }
    
    return NULL;    // this should not happen
  }
    
    
  // is this keyword special url?
  function is_special($lang_code)
  {
    if ((!empty($lang_code)) && (in_array($lang_code, $this->special)))
      return TRUE;
    else
      return FALSE;
  }
 
  // to change language of the uri, this will return localized current uri
  function switch_uri($lang)
  {
    if ((!empty($this->uri)) && (array_key_exists($lang, $this->languages)))
    {

      if ($uri_segment = $this->get_uri_lang($this->uri))
      {
        // HRVOJE 11.05.2014. Fix for switch_uri() if special URI
        if(!$this->is_special($uri_segment['parts'][0])){
          $uri_segment['parts'][0] = $lang;
        }
        $uri = implode('/',$uri_segment['parts']);
      }
      else
      {
        $uri = $lang.'/'.$this->uri;
      }
    }

    return $uri;
  }
    
  //check if the language exists
  //when true returns an array with lang abbreviation + rest
  function get_uri_lang($uri = '')
  {
    if (!empty($uri))
    {
      $uri = ($uri[0] == '/') ? substr($uri, 1): $uri;
      
      $uri_expl = explode('/', $uri, 2);
      $uri_segment['lang'] = NULL;
      $uri_segment['parts'] = $uri_expl;  
      
      if (array_key_exists($uri_expl[0], $this->languages))
      {
        $uri_segment['lang'] = $uri_expl[0];
      }
      return $uri_segment;
    }
    else
      return FALSE;
  }

    
  // default language: first element of $this->languages
  function default_lang()
  {
    $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
    $browser_lang = substr($browser_lang, 0,2);
    if(array_key_exists($browser_lang, $this->languages))
        return $browser_lang;
    else{
        // use only this code not to affect default lang by HTTP_ACCEPT_LANGUAGE
        reset($this->languages);
        return key($this->languages);
    }
  }
    
    
  // add language segment to $uri (if appropriate)
  function localized($uri)
  {
    if (!empty($uri))
    {
      $uri_segment = $this->get_uri_lang($uri);
      if (!$uri_segment['lang'])
      {

        if ((!$this->is_special($uri_segment['parts'][0])) && (!preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri)))
        {
          $uri = $this->lang() . '/' . $uri;
        }
      }
    }
    return $uri;
  }


  /**  mislim da ovo ionako ne radi
     * Same behavior as the parent method, but it can load the first defined 
     * lang configuration (in first default language) to fill other languages gaps. This is very useful
     * because you don't have to update all your lang files during development
     * each time you update a text. If a constant is missing it will load
     * it in the first language configured in the array $languages. (OPB)
     * 
     * 
     * @param boolean $load_first_lang false to keep the old behavior. Please
     * modify the default value to true to use this feature without having to 
     * modify your code 
     */
  /*function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $load_first_lang = false) {
        if ($load_first_lang) {
            reset($this->languages);
            $firstKey = key($this->languages);
            $firstValue = $this->languages[$firstKey];

            if ($this->lang_code != $firstKey) {
                $addedLang = parent::load($langfile, $firstValue, $return, $add_suffix, $alt_path);
                if ($addedLang) {
                    if ($add_suffix) {
                        $langfileToRemove = str_replace('.php', '', $langfile);
                        $langfileToRemove = str_replace('_lang.', '', $langfileToRemove) . '_lang';
                        $langfileToRemove .= '.php';
                    }
                    $this->is_loaded = array_diff($this->is_loaded, array($langfileToRemove));
                }
            }
        }
        return parent::load($langfile, $idiom, $return, $add_suffix, $alt_path);
    }*/
  


  public function get_languages(){ // HRVOJE 03.12.2013. SEO to do rel="alternative"
    return $this->languages;
  }

  public function trim_uri_lang() // HRVOJE 03.12.2013. SEO to do rel="alternative" x-default
  {
    $uri = $this->uri;
    if (!empty($uri))
    {
      if ($uri_segment = $this->get_uri_lang($this->uri))
      {
        unset($uri_segment['parts'][0]);
        $uri = implode('/',$uri_segment['parts']);
      }
    }

    return $uri;
  }
} 

// END MY_Lang Class

/* End of file MY_Lang.php */
/* Location: ./application/core/MY_Lang.php */