<?php

class Hslide
{

    protected $baseDirectory, $themeName;

    /**
     * @param string
     * @param string
     */
    function __construct($baseDirectory, $themeName)
    {
        $this->baseDirectory = $baseDirectory;
        $this->themeName = $themeName;
        $this->validateThemeName($themeName);
    }

    protected function validateThemeName($themeName)
    {
        if (!preg_match('/^[[:alpha:]][-[:alnum:]_]*$/', $themeName)) {
            throw new ErrorException('invalid theme name: ' . $themeName);
        }

        if (!is_file($this->baseDirectory . '/theme/' . $this->themeName . '/template.php')) {
            throw new ErrorException('no such theme: ' . $this->themeName);
        }
    }

    /**
     * @param string
     * @return string
     */
    function render($text)
    {
        $slides = array();
        $config = array(
            'superprehandler' => array($this, 'spreHandler')
        );
        foreach ($this->split(HatenaSyntax::parse($text)) as $node) {
            $slides[] = HatenaSyntax::renderNode($node, $config);
        }

        return $this->renderTemplate($slides);
    }

    /**
     * @param string
     * @param array
     * @return string
     */
    function spreHandler($type, array $lines)
    {
        if ($type === 'raw') {
            return implode("\n", $lines);
        }

        $content = implode("\n", array_map(array($this, 'escape'), $lines));
        return $type === ''
            ? '<pre>' . $content . '</pre>'
            : '<pre class="prettyprint lang-' . $this->escape($type) . '">' . $content . '</pre>';
    }

    /**
     * @param string
     * @return sring
     */
    protected function escape($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    protected function renderTemplate($slides)
    {
        $basePath = './theme/' . $this->themeName;
        ob_start();
        include $this->baseDirectory . '/theme/' . $this->themeName . '/template.php';
        return ob_get_clean();
    }

    /**
     * @param HatenaSyntax_Node
     * @return array
     */
    protected function split(HatenaSyntax_Node $root_node)
    {
        $nodes = $root_node->getData();
        $pages = array();
        for ($i = 0; $i < count($nodes); $i++) {
            $page = array();
            for (; $i < count($nodes); $i++) {
                if ($nodes[$i]->getType() === 'separator') {
                    $i++;
                    break;
                }
                $page[] = $nodes[$i];
            }
            $pages[] = new HatenaSyntax_Node('root', $page);
        }
        return $pages;
    }

    /**
     * @param string
     */
    function write($text)
    {
        echo $this->render($text);
    }
}
