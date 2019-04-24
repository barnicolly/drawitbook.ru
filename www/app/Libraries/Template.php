<?php

namespace App\Libraries;

class Template
{
    private $_brand_name = '';
    private $_title_separator = '';

    private $_layout = 'layouts/base';

    private $_title = FALSE;

    private $_metadata = array();

    /**
     * Set page layout view (1 column, 2 column...)
     *
     * @access  public
     * @param   string $layout
     * @return  void
     */
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    /**
     * Set page title
     *
     * @access  public
     * @param   string $title
     * @return  void
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function setMetaNoChache()
    {
        $this->addMetadata('cache-control', 'max-age=0');
        $this->addMetadata('cache-control', 'no-cache');
        $this->addMetadata('expires', '0');
        $this->addMetadata('pragma', 'no-cache');
    }

    /**
     * Add metadata
     *
     * @access  public
     * @param   string $name
     * @param   string $content
     * @return  void
     */
    public function addMetadata($name, $content)
    {
        $name = htmlspecialchars(strip_tags($name));
        $content = htmlspecialchars(strip_tags($content));

        $this->_metadata[$name] = $content;
    }

    /**
     * @param $view
     * @param array $data
     * @return array|mixed|string
     * @throws \Throwable
     */
    public function loadView($view, $data = array())
    {

        // Title
        if (empty($this->_title)) {
            $title = $this->_brand_name;
        } else {
            $title = $this->_title . $this->_title_separator . $this->_brand_name;
        }

        // Metadata
        $metadata = array();
        foreach ($this->_metadata as $name => $content) {
            if (strpos($name, 'og:') === 0) {
                $metadata[] = '<meta property="' . $name . '" content="' . $content . '">';
            } else {
                $metadata[] = '<meta name="' . $name . '" content="' . $content . '">';
            }
        }
        $metadata = implode('', $metadata);

        $content = view($view, $data)->with([
            'title' => $title,
            'metadata' => $metadata,
        ])->render();
        return $content;
    }
}