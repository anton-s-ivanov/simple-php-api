<?php

    class Forms
    {
        
        public function index()
        {
            echo self::resetDB;
            echo '<hr>';
            echo self::storeItem;
            echo '<hr>';
            echo self::updateItem;
            echo '<hr>';
            echo self::showItem;
            echo '<hr>';
            echo self::deleteItem;
        }


        const resetDB = '
            <h2>Подготовить БД</h2>
            <form action="/migrateAndSeed" method="POST">
                <input type="submit" value="Запустить скрипт подготовки БД">
            </form>
        ';

        const storeItem = '
            <h2>Создать Item</h2>
            <form action="/storeItem" method="POST">
                <input name="name" placeholder="name">
                <input name="phone" placeholder="phone">
                <input name="key" placeholder="key">
                <br><br>
                <input name="user_id" placeholder="user_id">
                <input name="token" placeholder="token">
                <input type="submit">
            </form>
        ';

        const updateItem = '
            <h2>Обновить Item</h2>
            <form action="/updateItem" method="POST">
                <input name="id" placeholder="id">
                <input name="name" placeholder="name">
                <input name="phone" placeholder="phone">
                <input name="key" placeholder="key">
                <br><br>
                <input name="user_id" placeholder="user_id">
                <input name="token" placeholder="token">
                <input type="submit">
            </form>
        ';

        const showItem = '
            <h2>Показать Item</h2>
            <form action="/showItem" method="POST">
                <input name="id" placeholder="item id">
                <br><br>
                <input name="user_id" placeholder="user_id">
                <input name="token" placeholder="token">
                <input type="submit">
            </form>
        ';

        const deleteItem = '
            <h2>Удалить Item</h2>
            <form action="/deleteItem" method="POST">
                <input name="id" placeholder="item id">
                <br><br>
                <input name="user_id" placeholder="user_id">
                <input name="token" placeholder="token">
                <input type="submit">
            </form>
        ';

    }