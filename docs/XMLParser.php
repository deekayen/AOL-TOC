<?php

error_reporting(0);

// define search types
define('DOC_SEARCH_FUNC',   'func');
define('DOC_SEARCH_DESC',   'desc');

/**
 * XMLParser: A class for abstracting XML files
 *
 * @author $Author: andrew $
 * @version $Revision: 1.1 $
 */
class XMLParser
{

    var $i = 0;
    var $data;
    var $packageInfo = array();

    /**
     * XMLParser: XMLParser class constructor
     *
     * @param string $file      File to read for processing
     * @param string $className Class to read tags from
     * @access public
     * @return void
     */
    function XMLParser($file, $className)
    {
        $this->currentClass = $className;
        $data = $this->getTree($file);
        $list = array();

        $this->packageInfo[$data['tag']] = $data['attributes'];

        for ($i=0; $i < count($data['children']); $i++) {
            for ($j=0; $j < count($data['children'][$i]['children']); $j++) {
                $list[$data['children'][$i]['attributes']['name']][] = $data['children'][$i]['children'][$j];
            }
        }

        $this->data = $list;
    }

    /**
     * setClass: Set class internally for parsing
     *
     * @param string $className Class name to parse
     * @access private
     * @return void
     */
    function setClass($className)
    {
        $this->currentClass = $className;
    }
    
    /**
     * getTree: Parses XML file into a multidimensional array
     *
     * @param string $file File to read for processing
     * @access private
     * @return array
     */
    function getTree($file)
    {
        $data = file_get_contents($file);
        
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE,   1);
        xml_parse_into_struct($parser, $data, $vals, $index);
        xml_parser_free($parser);

        return array(
            'tag'        => $vals[0]['tag'],
            'attributes' => isset($vals[0]['attributes']) ? $vals[0]['attributes'] : null,
            'children'   => $this->getChildren($vals, $this->i = 0)
            );
    }

    /**
     * getRawData: Returns raw array created by parser
     *
     * @access public
     * @return array
     */
    function getRawData()
    {
        return $this->data;
    }

    /**
     * getChildren: Sets and retrieves child nodes in XML array
     *
     * @param string $vals  Values to assign to child nodes
     * @param string $i     Array pointer (passed by reference)
     * @access private
     * @return array
     */   
    function getChildren($vals, &$i)
    {
        $children = array();
    
        if (isset($vals[$i]['value'])) $children[] = $vals[$i]['value'];
        
        while (++$i < count($vals)) {
            switch ($vals[$i]['type'])
            {
                case 'cdata':
                    $children[] = $vals[$i]['value'];
                    break;
            
                case 'complete':
                    $children[] = array(
                        'tag'        => $vals[$i]['tag'],
                        'attributes' => isset($vals[$i]['attributes']) ? $vals[$i]['attributes'] : null,
                        'value'      => trim($vals[$i]['value']));
                    break;
                
                case 'open':
                    $children[] = array(
                        'tag'        => $vals[$i]['tag'],
                        'attributes' => isset($vals[$i]['attributes']) ? $vals[$i]['attributes'] : null,
                        'children'   => $this->getChildren($vals, $i));
                    break;

                case 'close':
                    return $children;
                    break;

            }
        }
    }


    /**
     * getClassList: Retrieves a list of all classes tagged in XML file
     *
     * @access public
     * @return array
     */
    function getClassList()
    {
        $c = array_keys($this->data);
        sort($c);
        return $c;
    }

    /**
     * getPackageInfo: reads information about the package from <package> tag
     *
     * @param string $attr Tag attribute to return
     * @access public
     * @return string
     */
    function getPackageInfo($attr)
    {
        return $this->packageInfo['package'][$attr];
    }
    

    /**
     * getFunctionList: Retrieves a list of functions from currently selected class
     *
     * @access public
     * @return array
     * @see setClass
     */
    function getFunctionList()
    {
        $list = array();
        
        for ($i=0; $i < count($this->data[$this->currentClass]); $i++) {
            $list[] = $this->data[$this->currentClass][$i]['attributes']['name'];
        }

        return $list;
    }
    
    /**
     * getFunctionCount: Counts functions in currently selected class
     *
     * @access public
     * @return string
     * @see setClass
     */
    function getFunctionCount()
    {
        $num = 0;

        for ($i=0; $i < count($this->data[$this->currentClass]); $i++) {
            $num += 1;
        }

        return $num;
    }

    /**
     * getFunctionData: Retrieves function attributes from selected function
     *
     * @param string $function Function to parse details for
     * @access public
     * @return array
     * @see setClass
     */
    function getFunctionData($function)
    {
        $list = array();
        $magicNumber = 0;

        for ($i=0; $i < count($this->data[$this->currentClass]); $i++) {
            if ($this->data[$this->currentClass][$i]['attributes']['name'] == $function) {
                $magicNumber = $i;
                break 1;
            }
        }

        $this->data[$this->currentClass][$magicNumber]['attributes']['value'] = $this->data[$this->currentClass][$magicNumber]['value'];
        $array = $this->data[$this->currentClass][$magicNumber]['attributes'];
        return $array;
    }

    /**
     * getFunctionDescription: Retrieves function description, and places them in an array
     *
     * @param string $function Function to parse description for
     * @access public
     * @return array
     * @see setClass
     */
    function getFunctionDescription($function)
    {
        $list = array();
        $magicNumber = 0;

        for ($i=0; $i < count($this->data[$this->currentClass]); $i++) {
            if ($this->data[$this->currentClass][$i]['attributes']['name'] == $function) {
                $magicNumber = $i;
                break 1;
            }
        }

        $list['short'] = $this->replaceTags(trim($this->data[$this->currentClass][$magicNumber]['children'][0]));
        $list['long'] = $this->replaceTags(trim($this->data[$this->currentClass][$magicNumber]['children'][1]['value']));

        return $list;
           
    }

    /**
     * colorizeProto: Colorizes and parse fucntion prototype
     *
     * @param string $prototype Protoype to parse for colorization
     * @access public
     * @return string
     * @see setClass
     * @see getFunctionList
     */
    function colorizeProto($proto)
    {
        $red = array('private', 'protected');
        $redR = array('<span style="color:red">private</span>',
            '<span style="color:red">protected</span>');
        $green = array('public');
        $greenR = array('<span style="color:green">public</span>');
        $blue = array('string', 'integer', 'boolean', 'object', 'double', 'float', 'mixed', 'array', 'void');
        $blueR = array('<span style="color:blue">string</span>',
            '<span style="color:blue">integer</span>',
            '<span style="color:blue">boolean</span>',
            '<span style="color:blue">object</span>',
            '<span style="color:blue">double</span>',
            '<span style="color:blue">float</span>',
            '<span style="color:blue">mixed</span>',
            '<span style="color:blue">array</span>',
            '<span style="color:blue">void</span>');
        $data = str_replace($red, $redR, $proto);
        $data = str_replace($blue, $blueR, $data);
        $data = str_replace($green, $greenR, $data);

        return $data;
    }

    /**
     * replaceTags: replaces bbcode-style tags with real HTML tags
     *
     * @param string $string String to parse for replacing
     * @access public
     * @return string
     */
    function replaceTags($string)
    {
        $ret = str_replace(array('[', ']'), array('<', '>'), $string);
        return nl2br($ret); // $this->colorizeProto($ret));
    }

    // independent fucntion, fully customized, sorry  :\
    function searchFunctions($searchStr)
    {
        $funcResults = array();
        $descResults = array();

        $match = '/' . $searchStr . '/';

        foreach ($this->getFunctionList() as $f) {
            if (preg_match($match, $f)) $funcResults[] = $f;
            $data = $this->getFunctionDescription($f);
            if (preg_match($match, $data['long'])) $descResults[$f] = str_replace($searchStr, '<span style="background:green;color:white">'.$searchStr.'</span>', $data['long']);
        }

        return array('func' => $funcResults, 'desc' => $descResults);
    }

} // end class XMLParser


?> 