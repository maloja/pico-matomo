<?php
/**
 * Matomo web analytics plugin for Pico CMS
 * Edited January 2020 by maloja
 *
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link    https://github.com/maloja/pico-matomo
 * @author  maloja
 *
 * Configuration (config/config.yml)
 *      matomo:
 *          id: [matomo id]
 *          server: [matomo server]
 *
 * Operation:
 * This Plugin will let you enjoy the power of Matomo web analytics for all
 * your [Pico CMS](http://picocms.org) pages.The matomo Opt-Out Code can be
 * added into pages with the keyword (% matomo %)
 */
class PicoMatomo extends AbstractPicoPlugin
{
    /**
     * API version used by this plugin
     */
    const API_VERSION = 2;

    /**
     * This plugin is not disabled by default
     */
    protected $enabled = true;


    /**
     * This plugin depends on ...
     */
    protected $dependsOn = array();

    /**
     * Private variables
     */
    private $id;
    private $server;
    private $lang;
    private $opt_out_code;
    private $pluginPath;

    /**
     * Read the configuration files and prepair opt_out string
	 */
	public function onConfigLoaded(array &$config)
	{
	    $this->pluginPath = $config[ 'plugins_url' ]."/PicoMatomo/";
	    $this->id = $config['matomo']['id'];
	    $this->server = $config['matomo']['server'];
	    $this->lang = $config['matomo']['lang'];
	    if ( ($this->id) && ($this->server) ) {
            $this->server = rtrim($this->server, '/') . '/';
        	if (!preg_match("~^(?:f|ht)tps?://~i", $this->server)) {
        	    $this->server = "https://" . $this->server;
        	}
        	$this->opt_out_code  = '<iframe title="Matomo OptOut" id="iFrame1" style="border: 0px solid #888; height: 300px; width: 100%;" ';
        	$this->opt_out_code .= 'src="' . $this->server . 'index.php?';
        	$this->opt_out_code .= 'module=CoreAdminHome&action=optOut&language=' . $this->lang;
        	$this->opt_out_code .= '&backgroundColor=&fontColor=488cdb&fontSize=18px&fontFamily=sans"></iframe>';
        }
	}

    /**
     * Triggered after Pico has rendered the page
     *
     * @param  string &$output contents which will be sent to the user
     * @return void
     */
	public function onPageRendered(&$output) {
		if ( ($this->id) && ($this->server) ) {
		    $tracking = file_get_contents($this->pluginPath . "tracking-code.inc");
		    $tracking = preg_replace( '/\\[\\[server\\]\\]/', $this->server, $tracking);
		    $tracking = preg_replace( '/\\[\\[id\\]\\]/', $this->id, $tracking);
		    $output   = preg_replace( '/\<\/head\>[\s|\r|\n]*?\<body\>/', "\n</head>\n<body>\n{$tracking}", $output, 1);
	   	}
	}

	/**
     * Replace (% matomo %) opt-out tags
     * Triggered after Pico has prepared the raw file contents for parsing
     */
    public function onContentPrepared(&$content)
    {
        $content = preg_replace('/\\(%\s*matomo\s*%\\)/', $this->opt_out_code, $content );
    }
}
