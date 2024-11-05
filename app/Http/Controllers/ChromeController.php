<?php

namespace App\Http\Controllers;
use HeadlessChromium\Page;
use HeadlessChromium\BrowserFactory;

use Illuminate\Http\Request;

class ChromeController extends Controller
{
    public function index() {

        //$browserFactory = new BrowserFactory();
        $browserFactory = new BrowserFactory('/usr/bin/chromium');

        // starts headless chrome
        $browser = $browserFactory->createBrowser([
            'headless' => true,
            'noSandbox' => true,
            'timeout' => 60000
        ]);

        // creates a new page and navigate to an url
        $page = $browser->createPage();
        $page->navigate('https://www.nike.com/jp/t/%E3%82%A8%E3%82%A2-%E3%82%B8%E3%83%A7%E3%83%BC%E3%83%80%E3%83%B3-1-low-%E3%82%A6%E3%82%A3%E3%83%A1%E3%83%B3%E3%82%BA%E3%82%B7%E3%83%A5%E3%83%BC%E3%82%BA-q9VcG7/DC0774-001')
            ->waitForNavigation(Page::LOAD, 60000);
        //javascript実行の結果を待つ
        //sleep(5);

        // get page title
        $pageTitle = $page->evaluate('document.title')->getReturnValue();
        echo "Page Title: " . $pageTitle . "\n";



        // screenshot - Say "Cheese"! 😄
        $page->screenshot()->saveToFile('./foo/bar.png');

        // pdf
        $page->pdf(['printBackground'=>false])->saveToFile('./foo/bar.pdf');

        // Get a specific element by its XPATH
        $elementXpath = '//*[@id="buyTools"]/div[1]/fieldset/div';
        
        $elementContent = $page->evaluate("document.evaluate('$elementXpath', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue.innerHTML")->getReturnValue();
        echo "Element Content: " . htmlspecialchars($elementContent) . "\n";

        
        // bye
        $browser->close();

        echo '[' . 'done' . ']<br />' . "\n";exit;
    }
}
