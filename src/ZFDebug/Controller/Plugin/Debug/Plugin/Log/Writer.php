<?php
namespace ZFDebug\Controller\Plugin\Debug\Plugin\Log;

use Zend_Log_Writer_Abstract;

class Writer extends Zend_Log_Writer_Abstract
{

    protected $_messages = [];

    protected $_errors = 0;

    public static function factory($config)
    {
        return new self();
    }

    public function getMessages()
    {
        return $this->_messages;
    }

    public function getErrorCount()
    {
        return $this->_errors;
    }

    /**
     * Write a message to the log.
     *
     * @param  array $event event data
     *
     * @return void
     */
    protected function _write($event)
    {
        // $output = '<table cellspacing="10">';
        $output = '<tr>';
        $output .= '<td style="color:%color%;text-align:right;padding-right:1em">%priorityName%</td>';
        $output .= '<td style="color:%color%;text-align:right;padding-right:1em">%memory%</td>';
        $output .= '<td style="color:%color%;">%message%</td></tr>'; // (%priority%)
        $event['color'] = '#C9C9C9';
        // Count errors
        if ($event['priority'] < 7) {
            $event['color'] = 'green';
        }
        if ($event['priority'] < 6) {
            $event['color'] = '#fd9600';
        }
        if ($event['priority'] < 5) {
            $event['color'] = 'red';
            $this->_errors++;
        }
        if ($event['priority'] == \ZFDebug\Controller\Plugin\Debug\Plugin\Log::ZFLOG) {
            $event['priorityName'] = $event['message']['time'];
            $event['memory'] = $event['message']['memory'];
            $event['message'] = $event['message']['message'];
        } else {
            // self::$_lastEvent = null;
            $event['message'] = $event['priorityName'] . ': ' . $event['message'];
            $event['priorityName'] = '&nbsp;';
            $event['memory'] = '&nbsp;';
        }
        foreach ($event as $name => $value) {
            if ('message' == $name) {
                $measure = '&nbsp;';
                if ((is_object($value) && !method_exists($value, '__toString'))) {
                    $value = gettype($value);
                } elseif (is_array($value)) {
                    $measure = $value[0];
                    $value = $value[1];
                }
            }
            $output = str_replace("%$name%", $value, $output);
        }
        $this->_messages[] = $output;
    }
}