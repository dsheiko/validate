<?php
use Dsheiko\Reflection;

const TEST_TARGET_CLASS = "\\Dsheiko\Validate\\IsInt";

include_once __DIR__ . '/Fixtures/IsInt/Exception.php';
include_once __DIR__ . '/Fixtures/IsInt/Min/Exception.php';
include_once __DIR__ . '/Fixtures/IsInt/Max/Exception.php';
include_once __DIR__ . '/Fixtures/IsInt.php';

describe("\\Dsheiko\\Validate\\ValidateAstract", function() {

    /**
     *  @covers Dsheiko\Validate\ValidateAstract::prepareTplData
     */
    describe('::prepareTplData()', function() {

        it("returns corresponding method name", function() {
            $method = Reflection::staticMethod(TEST_TARGET_CLASS, "prepareTplData");
            $res = $method(1, ["min" => 10]);
            expect($res["{value}"])->to->equal("1");
            expect($res["{min}"])->to->equal("10");
        });

    });

    /**
     *  @covers Dsheiko\Validate\ValidateAstract::throwException
     */
    describe('::throwException()', function() {

        it("throws corresponding Exception", function() {
            expect(function() {
                $method = Reflection::staticMethod(TEST_TARGET_CLASS, "throwException");
                $method('Dsheiko\Validate\IsInt');
            })->to->throw("\\Dsheiko\Validate\IsInt\Exception");
        });

        it("throws corresponding option Exception", function() {
            expect(function() {
                $method = Reflection::staticMethod(TEST_TARGET_CLASS, "throwException");
                $method('Dsheiko\Validate\IsInt', 'min');
            })->to->throw("\\Dsheiko\Validate\IsInt\Min\Exception");
        });

        it("throws exception in case there is no class matching name", function() {
            expect(function() {
                $method = Reflection::staticMethod(TEST_TARGET_CLASS, "throwException");
                $method('NoneSense', 'min');
            })->to->throw("\\RuntimeException");
        });

    });

    /**
     *  @covers Dsheiko\Validate\ValidateAstract::getOptionTestMethod
     */
    describe('::getOptionTestMethod()', function() {

        it("returns corresponding method name", function() {
            $method = Reflection::staticMethod(TEST_TARGET_CLASS, "getOptionTestMethod");
            $res = $method('min');
            expect($res)->to->equal("testOptionMin");
        });

    });

    /**
     *  @covers Dsheiko\Validate\ValidateAstract::getExceptionClass
     */
    describe('::getExceptionClass()', function() {

        it("returns corresponding Exception class name", function() {
            $method = Reflection::staticMethod(TEST_TARGET_CLASS, "getExceptionClass");
            $res = $method('Dsheiko\Validate\IsInt');
            expect($res)->to->equal("\Dsheiko\Validate\IsInt\Exception");
        });

        it("returns corresponding option Exception class name", function() {
            $method = Reflection::staticMethod(TEST_TARGET_CLASS, "getExceptionClass");
            $res = $method('Dsheiko\Validate\IsInt', 'min');
            expect($res)->to->equal("\Dsheiko\Validate\IsInt\Min\Exception");
        });

    });

    /**
     *  @covers Dsheiko\Validate\ValidateAstract::validate
     */
    describe('::validate()', function() {

        it("throws corresponding Exception", function() {
            expect(function() {
                $v = new \Fixtures\isInt();
                $v->validate(10, ["min" => 20]);
            })->with("10 is too hight; must be less than 20")->to->throw("\\Fixtures\IsInt\Min\Exception");
        });

        it("throws exception when method not found", function() {
            expect(function() {
                $v = new \Fixtures\isInt();
                $v->validate(10, ["NonSense" => 20]);
            })->to->throw("\\RuntimeException");
        });

    });
});

