<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\LocationCode;
use PHPUnit\Framework\TestCase;

class LocationCodeTest extends TestCase
{
    public function test_full_location_code()
    {
        $this->assertEquals('AUK-R3-S32', LocationCode::of(
            warehouse: 'AUK',
            rack: 'R3',
            shelf: 'S32'
        )->locationCode());

        $this->assertEquals('AUK-R3-S32', LocationCode::of([
            'warehouse' => 'AUK',
            'rack' => 'R3',
            'shelf' => 'S32',
        ])->locationCode());
    }

    public function test_location_code_without_warehouse()
    {
        $this->assertEquals('R3-S32', LocationCode::of(
            rack: 'R3',
            shelf: 'S32'
        )->locationCode());

        $this->assertEquals('R3-S32', LocationCode::of([
            'rack' => 'R3',
            'shelf' => 'S32',
        ])->locationCode());
    }

    public function test_location_code_without_shelf()
    {
        $this->assertEquals('AUK-R3', LocationCode::of(
            warehouse: 'AUK',
            rack: 'R3'
        )->locationCode());

        $this->assertEquals('AUK-R3', LocationCode::of([
            'warehouse' => 'AUK',
            'rack' => 'R3',
        ])->locationCode());
    }

    public function test_location_code_with_only_warehouse()
    {
        $this->assertEquals('AUK', LocationCode::of(
            warehouse: 'AUK'
        )->locationCode());

        $this->assertEquals('AUK', LocationCode::of([
            'warehouse' => 'AUK',
        ])->locationCode());
    }

    public function test_location_code_with_only_rack_excepted()
    {
        $this->expectException(\InvalidArgumentException::class);

        LocationCode::of([
            'rack2' => 'R3',
        ]);
    }

    public function test_location_code_with_only_shelf_excepted()
    {
        $this->expectException(\InvalidArgumentException::class);

        LocationCode::of([
            'shelf2' => 'S32',
        ]);
    }

    public function test_location_code_with_empty()
    {
        $this->expectException(\InvalidArgumentException::class);

        LocationCode::of();
    }

    public function test_location_code_to_string()
    {
        $this->assertEquals('AUK-R3-S32', (string) LocationCode::of(
            warehouse: 'AUK',
            rack: 'R3',
            shelf: 'S32'
        ));

        $this->assertEquals('AUK-R3-S32', (string) LocationCode::of([
            'warehouse' => 'AUK',
            'rack' => 'R3',
            'shelf' => 'S32',
        ]));
    }
}
