<?php

/**
 * Class User with all function for user
 */
class User
{
    /**
     * Show all user in databade
     * @return user[] from table user
     */
    public function showAllUser()
    {
        $connect = new SQLconnectionPDO();
        $connectToBD = $connect->connect();
        $sth = $connectToBD->prepare("SELECT * FROM user");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
