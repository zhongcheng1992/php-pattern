<?php
namespace Mvc\Controller;

use Michelf\MarkdownExtra;
use Service\Mvc\Controller;


class DocsController extends Controller
{
    public function index()
    {

        if (!isset($_GET['s'])) {
            $this->view->disable();
            echo '<a href="?s=factory.md">工厂模式</a>';
            exit();
        }

        $name = $_GET['s'];
        $file = file_get_contents(BASE_PATH . '/docs/' . $name);

        $doc = MarkdownExtra::defaultTransform($file);


        $this->view->set('doc', $doc);
        $this->view->set('title', '文档');
    }
}