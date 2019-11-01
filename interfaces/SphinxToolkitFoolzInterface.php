<?php

namespace Arris;

use Closure;
use Foolz\SphinxQL\Drivers\ResultSetInterface;
use Foolz\SphinxQL\Exception\DatabaseException;
use Foolz\SphinxQL\SphinxQL;

/**
 * Interface __SphinxToolkitFoolzInterface
 *
 *
 *
 * @package Arris\Toolkit
 */
interface SphinxToolkitFoolzInterface {

    /**
     * Инициализация статического интерфейса к методам
     *
     * @param string $sphinx_connection_host
     * @param string $sphinx_connection_port
     * @param array $options
     */
    public static function init(string $sphinx_connection_host, string $sphinx_connection_port, $options = []);

    /**
     * Создает коннекшен для множественных обновлений (в крон-скриптах, к примеру, вызывается после init() )
     */
    public static function initConnection();

    /**
     * Создает инстанс SphinxQL (для однократного обновления)
     *
     * @return SphinxQL
     */
    public static function createInstance();

    /**
     * Обновляет (UPDATE) реалтайм-индекс по набору данных
     * с созданием коннекшена "сейчас"
     *
     * @param string $index_name
     * @param array $updateset
     * @return ResultSetInterface|null
     *
     * @throws DatabaseException
     * @throws \Foolz\SphinxQL\Exception\ConnectionException
     * @throws \Foolz\SphinxQL\Exception\SphinxQLException
     */
    public static function rt_UpdateIndex(string $index_name, array $updateset);

    /**
     * Замещает (REPLACE) реалтайм-индекс по набору данных
     * с созданием коннекшена "сейчас"
     *
     * @param string $index_name
     * @param array $updateset
     * @return ResultSetInterface|null
     *
     * @throws DatabaseException
     * @throws \Foolz\SphinxQL\Exception\ConnectionException
     * @throws \Foolz\SphinxQL\Exception\SphinxQLException
     */
    public static function rt_ReplaceIndex(string $index_name, array $updateset);

    /**
     * Удаляет строку реалтайм-индекса
     * с созданием коннекшена "сейчас"
     *
     * @param string $index_name        -- индекс
     * @param string $field             -- поле для поиска индекса
     * @param null $field_value         -- значение для поиска индекса
     * @return ResultSetInterface|null
     *
     * @throws DatabaseException
     * @throws \Foolz\SphinxQL\Exception\ConnectionException
     * @throws \Foolz\SphinxQL\Exception\SphinxQLException
     */
    public static function rt_DeleteIndex(string $index_name, string $field, $field_value = null);

    /**
     * @param \PDO $pdo_connection
     * @param string $sql_source_table
     * @param string $sphinx_index
     * @param Closure $make_updateset_method
     * @param string $condition
     * @return int
     * @throws DatabaseException
     * @throws \Foolz\SphinxQL\Exception\ConnectionException
     * @throws \Foolz\SphinxQL\Exception\SphinxQLException
     */
    public static function rt_RebuildAbstractIndex(\PDO $pdo_connection, string $sql_source_table, string $sphinx_index, Closure $make_updateset_method, string $condition = '');

    /**
     * Получает инстанс (для множественных обновлений)
     *
     * @return SphinxQL
     */
    public static function getInstance();
}