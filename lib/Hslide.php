<?php

class Hslide
{

    protected $template_path;

    /**
     * @param string
     */
    function __construct($template_path)
    {
        $this->template_path = $template_path;
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
        ob_start();
        include $this->template_path;
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
