<?php
use Dsheiko\Validate;
use Dsheiko\Validate\IsMap;

describe("\\Dsheiko\\Validate\\IsMap", function() {

    /**
     *  @covers Dsheiko\Validate\IsMap::isValid
     */
    describe('->isValid()', function() {

        describe('Optionality', function() {

            it("throws no exception if valid", function() {
                $params = ["foo" => 1 ];
                $v = new IsMap();
                expect($v->isValid($params, [
                    "foo" => Validate::MANDATORY,
                    "bar" => Validate::OPTIONAL
                ]))->to->be->ok;
            });

            it("throws exception if invalid", function() {
                $params = ["foo" => 1 ];
                $v = new IsMap();
                expect($v->isValid($params, [
                    "foo" => Validate::MANDATORY,
                    "bar" => Validate::MANDATORY
                ]))->to->be->not->ok;
                expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\Exception");
            });
            
        });

        describe('Contract', function() {

            it("throws no exception if valid", function() {
                $params = ["foo" => 10 ];
                $v = new IsMap();
                expect($v->isValid($params, [
                    "foo" => [ Validate::MANDATORY, "IsInt" => [ "min" => 10 ]]
                ]))->to->be->ok;
            });

            it("throws exception if invalid", function() {
                $params = ["foo" => 1 ];
                $v = new IsMap();
                expect($v->isValid($params, [
                    "foo" => [ Validate::MANDATORY, "IsInt" => [ "min" => 10 ]]
                ]))->to->be->not->ok;
                expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsInt\Min\Exception");
            });
        });

    });
});

