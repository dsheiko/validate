<?php
use Dsheiko\Reflection;
use Dsheiko\Validate;
use Dsheiko\Validate\Exception as ValidateException;

class CustomException extends ValidateException
{

}

describe("\\Dsheiko\\Validate::contract", function() {


    /**
     *  @covers Dsheiko\Validate::contract
     */
    describe('::contract', function() {

        it("throws exception in case of invalid contract ([1])", function() {
            expect(function() {
                Validate::contract([1]);
            })->to->throw(\InvalidArgumentException::class);
        });

        it("throws exception in case of invalid contract (['key' => 'value'])", function() {
            expect(function() {
                Validate::contract(["key" => "value"]);
            })->to->throw(\InvalidArgumentException::class);
        });

        it("throws exception in case of invalid contract (['key' => ['value']])", function() {
            expect(function() {
                Validate::contract(["key" => ["value"]]);
            })->to->throw(\InvalidArgumentException::class);
        });

        it("throws no exception if valid (contract as a string)", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      "IsInt, NotEmpty"],
                ]);
            })->to->not->throw(\Exception::class);
        });

        it("throws no exception if valid (contract as an array)", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      ["IsInt", "NotEmpty"]],
                ]);
            })->to->not->throw(\Exception::class);
        });

        it("throws no exception if valid (contract with options)", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      ["IsInt" => ["min" => 0, "max" => 100], "NotEmpty"]],
                ]);
            })->to->not->throw(\Exception::class);
        });

        it("throws no exception if valid (multiple contracts)", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      ["IsInt", "NotEmpty"]],
                    "bar" => ["BAR",  ["IsString", "NotEmpty"]],
                ]);
            })->to->not->throw(\Exception::class);
        });

        it("throws no exception if valid (mixed contracts)", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      ["IsInt" => ["min" => 0, "max" => 100], "NotEmpty"]],
                    "bar" => ["BAR",  "IsString, NotEmpty"],
                ]);
            })->to->not->throw(\Exception::class);
        });

        it("throws exception if invalid (does not complies constraints)", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      ["IsInt" => ["min" => 10, "max" => 100], "NotEmpty"]],
                ]);
            })->to->throw(Validate\IsInt\Min\Exception::class,
                "Parameter \"foo\" validation failed: 1 is too low; must be more than 10");
        });

        it("throws exception delegate if invalid", function() {
            expect(function() {
                Validate::contract([
                    "foo" => [1,      ["IsInt" => ["min" => 10, "max" => 100], "NotEmpty"]],
                ], CustomException::class);
            })->to->throw(CustomException::class,
                "Parameter \"foo\" validation failed: 1 is too low; must be more than 10");
        });

        it("throws no exception if valid (isMap contract)", function() {
            expect(function() {
                $value = ["title" => "some string"];
                Validate::contract([
                    "foo" => [
                        $value, [
                            "IsMap" => [
                                "title" => [Validate::MANDATORY, "IsString"]
                            ]
                        ]
                    ],
                ]);
            })->to->not->throw(\Exception::class);
        });

        it("throws exception if invalid (isMap contract)", function() {
            expect(function() {
                $value = ["title" => "some string"];
                Validate::contract([
                    "foo" => [
                        $value, [
                            "IsMap" => [
                                "title" => [Validate::MANDATORY, "IsInt"]
                            ]
                        ]
                    ],
                ]);
            })->to->throw(\Dsheiko\Validate\IsInt\Exception::class,
                'Parameter "foo" validation failed: Property "title" validation failed: "some strin.." is not an integer');
        });

    });

    /**
     *  @covers Dsheiko\Reflection::staticMethod
     *  @covers Dsheiko\Validate::normalizeOptionContract
     */
    describe('::normalizeOptionContract', function() {

        it("converts boolean to array", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'normalizeOptionContract');
            expect($method(Validate::MANDATORY))->to->equal([Validate::MANDATORY]);
        });

        it("does not convert array", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'normalizeOptionContract');
            expect($method([Validate::MANDATORY]))->to->equal([Validate::MANDATORY]);
        });

    });

});

