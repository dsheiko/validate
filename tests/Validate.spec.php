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

});

