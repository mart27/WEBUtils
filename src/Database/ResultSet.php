<?php
namespace WEBUtils\Database;

class ResultSet {

    private $re;
    private $array;

    function __construct($re) {
        $this->re = $re;
    }

    function FetchRow() {
        return mysqli_fetch_array($this->re);
    }

    function FetchRowObj() {
        return mysqli_fetch_object($this->re);
    }

    function GetOne() {
        $re = mysqli_fetch_array($this->re);
        reset($re);
        return (string) current($re);
    }

    function GetRow() {
        $re = mysqli_fetch_array($this->re);
        $keys = count(array_keys($re));
        return array_slice($re, 0, $keys);
    }

    function Close() {
        mysqli_free_result($this->re);
    }

    function NumRows() {
        return mysqli_num_rows($this->re) > 0 ? mysqli_num_rows($this->re) : false;
    }
    
    function lastInsertId(){
        return mysqli_insert_id();
    }
}