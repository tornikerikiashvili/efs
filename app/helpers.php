<?php

function test()
{
   return 'A Global Function with ';
}

function takeText($collection,$textcode)
{
   return $collection->where('text_code',$textcode)->first()['text_'.app()->getLocale()];

}