<?php
use Dsheiko\Reflection;
use Dsheiko\Validate;

describe("\\Dsheiko\\Validate", function() {

    /**
     *  @covers Dsheiko\Validate::__call
     */
    describe('->__call', function() {

        it("creates validation chain", function() {
            $v = new Validate();
            $v->IsString("str", ["minLength" => 10])
                ->IsInt(0, ["min" => 10]);

            expect(!$v->isValid())->to->be->ok;
            expect(in_array('"str" is too short; must be more than 10 chars', $v->getMessages()))->to->be->ok;
            expect(in_array("0 is too low; must be more than 10", $v->getMessages()))->to->be->ok;
        });

    });

    describe('->factory', function() {

        it("creates validator instance by a supplied name", function() {
            $v = new Validate();
            expect($v->factory("IsString"))->to->be->an->instanceof("\\Dsheiko\Validate\IsString");
        });

        it("throws exception when there is not class matching a supplied name", function() {
            expect(function() {
                $v = new Validate();
                $v->factory("NonSense");
            })->to->throw("\\RuntimeException");
        });

    });

    /**
     *  @covers Dsheiko\Validate::contract
     */
    describe('::contract', function() {


        it("throws exception in case of invalid contract (invalid type)", function() {
            expect(function() {
                Validate::contract([1], [100]);
            })->to->throw("\\RuntimeException");
        });

        it("throws exception in case of missing contract", function() {
            expect(function() {
                Validate::contract([1], []);
            })->to->not->throw("\\Exception");
        });

        it("throws no exception if valid (contract: ['foo', 'bar'])", function() {
            expect(function() {
                Validate::contract(
                    [1, "str"], [
                    ["IsInt", "NotEmpty"],
                    ["IsString", "NotEmpty"]
                ]);
            })->to->not->throw("\\Exception");
        });

        it("throws no exception if valid (contract: 'foo, bar')", function() {
            expect(function() {
                Validate::contract(
                    [1, "str"], [
                    "IsInt, NotEmpty",
                    "IsString, NotEmpty"
                ]);
            })->to->not->throw("\\Exception");
        });

        it("throws no exception if valid (contract: parametrized)", function() {
            expect(function() {
                Validate::contract(
                    [1, "str"], [
                    ["IsInt" => ["min" => 0, "max" => 100]],
                    ["IsString" => ["minLength" => 0, "notEmpty" => true]],
                ]);
            })->to->not->throw("\\Exception");
        });

        it("throws no exception if valid (contract: mixed)", function() {
            expect(function() {
                Validate::contract(
                    [1, "str"], [
                    ["IsInt" => ["min" => 0, "max" => 100]],
                    "IsString, NotEmpty"
                ]);
            })->to->not->throw("\\Exception");
        });

        it("throws exception if invalid", function() {
            expect(function() {
                Validate::contract(
                    [1, "str"], [
                    ["IsInt" => ["min" => 10]],
                    ["IsString"]
                ]);
            })->to->throw("\\Dsheiko\Validate\IsInt\Min\Exception");
        });

        it("throws no exception if given map complies the contract", function() {
            expect(function() {
                $params = ["title" => "some string"];
                Validate::contract([$params], [
                    [
                        "IsMap" => [
                            "title" => [Validate::MANDATORY, "IsString"]
                        ]
                    ],
                ]);
            })->to->not->throw("\\Exception");
        });

        it("throws exception otherwise", function() {
            expect(function() {
                $params = ["title" => "some string"];
                Validate::contract([$params], [
                    [
                        "IsMap" => [
                            "title" => [Validate::MANDATORY, "IsInt"]
                        ]
                    ],
                ]);
            })->to->throw("\\Exception");
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

    /**
     *  @covers Dsheiko\Reflection::staticMethod
     *  @covers Dsheiko\Validate::getMapEntryContractOptionality
     */
    describe('::getMapEntryContractOptionality', function() {

        it("extracts optionality from payload", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractOptionality');
            expect($method([Validate::MANDATORY]))->to->equal(Validate::MANDATORY);
        });

        it("throws run-time exception if invalid value", function() {
            expect(function() {
                $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractOptionality');
                $method(["invalid"]);
            })->to->throw("\\RuntimeException");
        });

    });

    /**
     *  @covers Dsheiko\Reflection::staticMethod
     *  @covers Dsheiko\Validate::getMapEntryContractValidators
     */
    describe('::getMapEntryContractValidators', function() {

        it("returns null if no validator specified", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractValidators');
            expect($method([Validate::MANDATORY]))->to->equal(null);
        });

        it("returns array for a sigle validator", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractValidators');
            expect($method([Validate::MANDATORY, "isInt"]))->to->equal(["isInt" => null]);
        });

        it("returns array for multiple validators", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractValidators');
            expect($method([
                Validate::MANDATORY,
                "isInt",
                "notEmpty"
            ]))->to->equal([
                "isInt" => null,
                "notEmpty" => null
            ]);
        });

        it("returns array for parametrizied validator", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractValidators');
            $ret = $method([Validate::MANDATORY, "isInt" => ["min" => 0]]);
            expect($ret["isInt"]["min"])->to->equal(0);
        });

        it("returns array for a string of validators", function() {
            $method = Reflection::staticMethod('\Dsheiko\Validate', 'getMapEntryContractValidators');
            expect($method([
                Validate::MANDATORY,
                "isInt, notEmpty"
            ]))->to->equal([
                "isInt" => null,
                "notEmpty" => null
            ]);
        });

    });

    /**
     *  @covers Dsheiko\Validate::map
     */
    describe('::map', function() {

        describe('contract as a boolean', function() {

            it("no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1, "bar" => 9];
                    Validate::map($params, [
                        "foo" => Validate::MANDATORY,
                        "bar" => Validate::OPTIONAL
                    ]);
                })->to->not->throw("\\Exception");
            });

            it("exception if mandatory property is missing", function() {
                expect(function() {
                    Validate::map(["bar" => 1], [
                        "foo" => Validate::MANDATORY
                    ]);
                })->to->throw("\\Exception");
            });

            it("exception if found a property out of the list of mandatory and optional", function() {
                expect(function() {
                    Validate::map(["baz" => 1], [
                        "bar" => Validate::OPTIONAL
                    ]);
                })->to->throw("\\Exception");
            });

        });

        describe('contract as a string', function() {

            it("no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsInt, NotEmpty"]
                    ]);
                })->to->not->throw("\\Exception");
            });

            it("no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsString"]
                    ]);
                })->to->throw("\\Dsheiko\Validate\IsString\Exception");
            });
        });

        describe('contract as an array', function() {

            it("no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsInt", "NotEmpty"]
                    ]);
                })->to->not->throw("\\Exception");
            });

            it("no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsInt" => ["min" => 10]]
                    ]);
                })->to->throw("\\Dsheiko\Validate\IsInt\Min\Exception");
            });

        });
    });
});

