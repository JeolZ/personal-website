<?php

// Cr�e par : Jo�l ZHU
// Date : 26/01/2018

/**
 * Classe de gestion d'une page Web permettant de s'affranchir de l'�criture de la structure de base du code HTML
 */
class WebPage {
    /**
     * Texte compris entre <head> et </head>
     * @var string
     */
    private $head  = null ;
    /**
     * Texte compris entre <title> et </title>
     * @var string
     */
    private $title = null ;
    /**
     * Texte compris entre <body> et </body>
     * @var string
     */
    private $body  = null ;
    
    /**
     * Constructeur
     * @param string $title Titre de la page
     */
    public function __construct($title=null) {
        $this->setTitle($title) ;
    }
    
    /**
     * Prot�ger les caract�res sp�ciaux pouvant d�grader la page Web
     * @param string $string La cha�ne � prot�ger
     *
     * @return string La cha�ne prot�g�e
     */
    public function escapeString($string) {
        return htmlentities($string, ENT_QUOTES|ENT_HTML5, "utf-8") ;
    }
    
    /**
     * Affecter le titre de la page
     * @param string $title Le titre
     */
    public function setTitle($title) {
        $this->title = $title ;
    }
    
    /**
     * Ajouter un contenu dans head
     * @param string $content Le contenu � ajouter
     *
     * @return void
     */
    public function appendToHead($content) {
        $this->head .= $content ;
    }
    
    /**
     * Ajouter un contenu CSS dans head
     * @param string $css Le contenu CSS � ajouter
     *
     * @return void
     */
    public function appendCss($css) {
        $this->appendToHead(<<<HTML
    <style type='text/css'>
    $css
    </style>
            
HTML
            ) ;
    }
    
    /**
     * Ajouter l'URL d'un script CSS dans head
     * @param string $url L'URL du script CSS
     *
     * @return void
     */
    public function appendCssUrl($url) {
        $this->appendToHead(<<<HTML
    <link rel="stylesheet" type="text/css" href="{$url}">
    
HTML
        ) ;
    }
    
    /**
     * Ajouter un contenu JavaScript dans head
     * @param string $js Le contenu JavaScript � ajouter
     *
     * @return void
     */
    public function appendJs($js) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript'>
    $js
    </script>
            
HTML
            ) ;
    }
    
    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param string $url L'URL du script JavaScript
     *
     * @return void
     */
    public function appendJsUrl($url) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript' src='$url'></script>
            
HTML
            ) ;
    }
    
    /**
     * Ajouter un contenu dans body
     * @param string $content Le contenu � ajouter
     *
     * @return void
     */
    public function appendContent($content) {
        $this->body .= $content ;
    }
    
    /**
     * Produire la page Web compl�te
     * @throws Exception si title n'est pas d�fini
     *
     * @return string
     */
    public function toHTML() {
        
        
        if (is_null($this->title)) {
            throw new Exception(__CLASS__ . ": title not set") ;
        }
        
        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{$this->title}</title>
{$this->head}
    </head>
    <body>
        <div id='page'>
{$this->body}
    </body>
</html>
HTML;
    }
}
