<?php

/**
 * User: Karel Wintersky
 *
 * Class TimerStats
 * Namespace: Arris
 *
 * Date: 10.04.2018, time: 6:14
 */

namespace Arris\Utils;

/**
 * Class TimerStats
 *
 * @package Arris
 */
class TimerStats implements TimerStatsInterface
{
    const DEFAULT_INTERNAL_NAME = 'default';

    const STATE_NEW = 0;
    const STATE_RUNNING = 1;
    const STATE_PAUSED = 2;
    const STATE_STOPPED = 3;

    public static $timers = array();

    public static function init($name = null, $desc = null)
    {
        $name = self::getTimerInternalName($name);

        if (\array_key_exists($name, self::$timers)) {
            unset( self::$timers[ $name ]);
        }

        self::$timers[ $name ] = array(
            'name'      =>  $name,
            'desc'      =>  $desc,
            'state'     =>  self::STATE_NEW,
            'time.start' =>  0,
            'time.total' =>  0,
            'iterations'=>  0
        );
    }

    public static function go($name = null)
    {
        $name = self::getTimerInternalName($name);

        if (self::$timers[ $name ]['state'] == self::STATE_STOPPED) {
            self::$timers[ $name ]['time.total'] = 0;
            self::$timers[ $name ]['iterations'] = 0;
        }

        self::$timers[ $name ]['state'] = self::STATE_RUNNING;
        self::$timers[ $name ]['time.start'] = microtime(true);
        self::$timers[ $name ]['iterations']++;
    }

    public static function pause($name = null)
    {
        $name = self::getTimerInternalName($name);

        self::$timers[ $name ]['state'] = self::STATE_PAUSED;
        self::$timers[ $name ]['time.total'] += ( \microtime(true) - self::$timers[ $name ]['time.start']);
    }

    public static function stop($name = null)
    {
        $name = self::getTimerInternalName($name);

        self::$timers[ $name ]['state'] = self::STATE_STOPPED;
        self::$timers[ $name ]['time.total'] += ( \microtime(true) - self::$timers[ $name ]['time.start']);
        return self::$timers[ $name ]['time.total'];
    }

    public static function stopAll()
    {
        foreach (self::$timers as $n => $timer) {
            if ($timer['iterations'] == 0) {
                unset(self::$timers[$n]);
                continue;
            }
            if ((self::$timers[ $n ]['state'] != self::STATE_STOPPED) && (self::$timers[ $n ]['state'] != self::STATE_PAUSED))
            {
                self::$timers[ $n ]['time.total'] += ( \microtime(true) - self::$timers[ $n ]['time.start']);
                self::$timers[ $n ]['state'] = self::STATE_STOPPED;
            }
        }
    }

    public static function get($name = null)
    {
        $name = self::getTimerInternalName($name);

        return self::$timers[ $name ]['time.total'];
    }

    public static function destroy($name = null)
    {
        $name = self::getTimerInternalName($name);

        if (\array_key_exists($name, self::$timers)) {
            unset( self::$timers[ $name ]);
            return true;
        } else {
            return false;
        }
    }

    public static function is_exists($name = null)
    {
        $name = self::getTimerInternalName($name);

        return \array_key_exists($name, self::$timers);
    }

    public static function get_state($name = null)
    {
        $name = self::getTimerInternalName($name);

        if (array_key_exists($name, self::$timers)) {
            return self::$timers[ $name ]['state'];
        } else {
            return false;
        }
    }

    public static function get_all_timers()
    {
        array_walk(self::$timers, function(&$item){
            unset($item['state']);
            unset($item['time.start']);
            unset($item['iterations']);
            $item['time'] = $item['time.total'];
            unset($item['time.total']);
        });
        return self::$timers;
    }

    private static function getTimerInternalName($name = null)
    {
        return
            (is_null($name) or $name === '')
            ? self::DEFAULT_INTERNAL_NAME
            : $name;
    }

}

# eof