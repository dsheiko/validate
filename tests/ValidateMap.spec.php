<?php
use Dsheiko\Reflection;
use Dsheiko\Validate;
use Dsheiko\Validate\Exception as ValidateException;

describe("\\Dsheiko\\Validate::map", function() {
    /**
     *  @covers Dsheiko\Reflection::staticMethod
     *  @covers Dsheiko\Validate::getMapEntryContractOptionality
     */
    describe('::getMapEntryContractOptionality', function() {

        it("extracts optionality from payload", function() {
            $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractOptionality');
            expect($method([Validate::MANDATORY]))->to->equal(Validate::MANDATORY);
        });

        it("throws run-time exception if invalid value", function() {
            expect(function() {
                $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractOptionality');
                $method(["invalid"]);
            })->to->throw(\InvalidArgumentException::class);
        });

    });

    /**
     *  @covers Dsheiko\Reflection::staticMethod
     *  @covers Dsheiko\Validate::getMapEntryContractValidators
     */
    describe('::getMapEntryContractValidators', function() {

        it("returns null if no validator specified", function() {
            $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractValidators');
            expect($method([Validate::MANDATORY]))->to->equal(null);
        });

        it("returns array for a sigle validator", function() {
            $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractValidators');
            expect($method([Validate::MANDATORY, "isInt"]))->to->equal(["isInt" => null]);
        });

        it("returns array for multiple validators", function() {
            $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractValidators');
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
            $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractValidators');
            $ret = $method([Validate::MANDATORY, "isInt" => ["min" => 0]]);
            expect($ret["isInt"]["min"])->to->equal(0);
        });

        it("returns array for a string of validators", function() {
            $method = Reflection::staticMethod(Validate::class, 'getMapEntryContractValidators');
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

            it("throws no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1, "bar" => 9];
                    Validate::map($params, [
                        "foo" => Validate::MANDATORY,
                        "bar" => Validate::OPTIONAL
                    ]);
                })->to->not->throw(\Exception::class);
            });

            it("throws exception if mandatory property is missing", function() {
                expect(function() {
                    Validate::map(["bar" => 1], [
                        "foo" => Validate::MANDATORY
                    ]);
                })->to->throw(ValidateException::class, "Property \"foo\" is mandatory");
            });

            it("throws exception if mandatory property violates the contract", function() {
                expect(function() {
                    Validate::map(["foo" => "BAR"], [
                        "foo" => [Validate::MANDATORY, "IsInt"],
                    ]);
                })->to->throw(ValidateException::class, 'Property "foo" validation failed: "BAR" is not an integer');
            });

            it("throws exception if mandatory property violates the contract (complex value)", function() {
                expect(function() {
                    Validate::map(["foo" => ["bar" => (object)["baz" => 1]]], [
                        "foo" => [Validate::MANDATORY, "IsInt"],
                    ]);
                })->to->throw(
                    ValidateException::class,
                    'Property "foo" validation failed: {"bar":{"b.. is not an integer'
                );
            });

            it("throws exception if optional property is missing", function() {
                expect(function() {
                    Validate::map(["baz" => 1], [
                        "bar" => Validate::OPTIONAL
                    ]);
                })->to->not->throw(\Exception::class);
            });

            it("throws exception if optional property violates the contract", function() {
                expect(function() {
                    Validate::map(["bar" => 1], [
                        "bar" => [Validate::OPTIONAL, "IsString"],
                    ]);
                })->to->throw(ValidateException::class, "Property \"bar\" validation failed: 1 is not a string");
            });

            it("throws exception delegate if mandatory property violates the contract", function() {
                expect(function() {
                    Validate::map(["foo" => "FOO"], [
                        "foo" => [Validate::OPTIONAL, "IsInt"],
                    ], \InvalidArgumentException::class);
                })->to->throw(
                    \InvalidArgumentException::class,
                    'Property "foo" validation failed: "FOO" is not an integer'
                );
            });

        });

        describe('contract as a string', function() {

            it("throws no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsInt, NotEmpty"]
                    ]);
                })->to->not->throw(\Exception::class);
            });

            it("throws no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsString"]
                    ]);
                })->to->throw(Validate\IsString\Exception::class);
            });
        });

        describe('contract as an array', function() {

            it("throws no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsInt", "NotEmpty"]
                    ]);
                })->to->not->throw(\Exception::class);
            });

            it("throws no exception if valid", function() {
                expect(function() {
                    $params = ["foo" => 1];
                    Validate::map($params, [
                        "foo" => [Validate::MANDATORY, "IsInt" => ["min" => 10]]
                    ]);
                })->to->throw(Validate\IsInt\Min\Exception::class);
            });

        });
    });
});

