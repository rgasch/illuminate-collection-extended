<?php

use Illuminate\Support\Collection as BaseCollection;
use Rgasch\Collection;

$array = [];
$start = 'a';
for($i=0; $i<5; $i++) {
    $array[$start++] = $i;
}

test('can create empty collection via constructor', function () {
    $collection = new Collection();
    $this->assertInstanceOf(Collection::class, $collection);
    $this->assertInstanceOf(BaseCollection::class, $collection);
    $this->assertCount(0, $collection);
});

test('can create empty collection via create() method', function () {
    $collection = Collection::create();
    $this->assertInstanceOf(Collection::class, $collection);
    $this->assertInstanceOf(BaseCollection::class, $collection);
    $this->assertCount(0, $collection);
});

test('can create collection with data via constructor', function () use ($array) {
    $collection = new Collection($array);
    $this->assertInstanceOf(Collection::class, $collection);
    $this->assertInstanceOf(BaseCollection::class, $collection);
    $this->assertCount(5, $collection);
    $this->assertEquals($collection->get('a'), 0);
    $this->assertEquals($collection->get('e'), 4);
});

test('can create collection with data via create() function', function () use ($array) {
    $collection = Collection::create($array);
    $this->assertInstanceOf(Collection::class, $collection);
    $this->assertInstanceOf(BaseCollection::class, $collection);
    $this->assertCount(5, $collection);
    $this->assertEquals($collection->get('a'), 0);
    $this->assertEquals($collection->get('e'), 4);
});

test('can fetch item via __get method', function () use ($array) {
    $collection = Collection::create($array);
    $this->assertInstanceOf(Collection::class, $collection);
    $this->assertInstanceOf(BaseCollection::class, $collection);
    $this->assertCount(5, $collection);
    $this->assertEquals($collection->a, 0);
    $this->assertEquals($collection->e, 4);
});

test('can set item via __set method', function () use ($array) {
    $collection = Collection::create($array);
    $collection->f = 5;
    $this->assertInstanceOf(Collection::class, $collection);
    $this->assertInstanceOf(BaseCollection::class, $collection);
    $this->assertCount(6, $collection);
    $this->assertEquals($collection->a, 0);
    $this->assertEquals($collection->f, 5);
});

test('can create recursive collection via create() method', function () use ($array) {
    $array['f'] = [ 'x'=>0, 'y'=>1, 'z'=>2 ];
    $collection = Collection::create($array);
    $this->assertEquals($collection->a, 0);
    $this->assertInstanceOf(Collection::class, $collection->f);
    $this->assertEquals($collection->f->x, 0);
});

test('can disable creation of recursive collection via create() method', function () use ($array) {
    $array['f'] = [ 'x'=>0, 'y'=>1, 'z'=>2 ];
    $collection = Collection::create($array, false);
    $this->assertEquals($collection->a, 0);
    $this->assertIsArray($collection->f);
    $this->assertEquals($collection->f['x'], 0);
});

test('dows throw exception when trying to retrieve non-existing element via __get method', function () use ($array) {
    $array['f'] = [ 'x'=>0, 'y'=>1, 'z'=>2 ];
    $collection = Collection::create($array, false);
    $collection->noSuchElement;
})->throws(\InvalidArgumentException::class);
