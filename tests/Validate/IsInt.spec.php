<?php
use Dsheiko\Validate\IsInt;

describe("\\Dsheiko\\Validate\\IsInt", function() {

    /**
     *  @covers Dsheiko\Validate\IsInt::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is 1", function() {
            $v = new IsInt();
            expect($v->isValid(1))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is -1", function() {
            $v = new IsInt();
            expect($v->isValid(-1), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns false if value is a string", function() {
            $v = new IsInt();
            expect(!$v->isValid("str"), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsInt\Exception");
        });

        it("returns false if value is an array", function() {
            $v = new IsInt();
            expect(!$v->isValid([]), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsInt\Exception");
        });

        it("returns true if value is 10, [ max => 20 ] ", function() {
            $v = new IsInt();
            expect($v->isValid(1), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is 10, [ min => 1 ] ", function() {
            $v = new IsInt();
            expect($v->isValid(1), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns false if value is 10, [ max => 5 ] ", function() {
            $v = new IsInt();
            expect(!$v->isValid(10, ["max" => 5]), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsInt\Max\Exception");
        });

        it("returns false if value is 10, [ min => 20 ] ", function() {
            $v = new IsInt();
            expect(!$v->isValid(10, ["min" => 20]), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsInt\Min\Exception");
        });

        it("generates a correct error message", function() {
            $v = new IsInt();
            $v->isValid("10");
            expect($v->getMessage())->to->equal('"10" is not an integer');
            $v->isValid(10, ["min" => 20]);
            expect($v->getMessage())->to->equal('10 is too low; must be more than 20');
            $v->isValid(10, ["max" => 1]);
            expect($v->getMessage())->to->equal('10 is too hight; must be less than 1');
        });
        
    });
});

