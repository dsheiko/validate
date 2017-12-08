<?php
use Dsheiko\Validate\IsString;

describe("\\Dsheiko\\Validate\\isString", function() {

    /**
     *  @covers Dsheiko\Validate\isString::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsString();
            expect($v->isValid('string'))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is 'string' and options have minLength => 1", function() {
            $v = new IsString();
            expect($v->isValid('string', ["minLength" => 1]), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is 'string' and options have maxLength => 20", function() {
            $v = new IsString();
            expect($v->isValid('string', ["maxLength" => 20]), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is 'string' and options have notEmpty => true", function() {
            $v = new IsString();
            expect($v->isValid('string', ["notEmpty" => true]), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns false if value is invalid", function() {
            $v = new IsString();
            expect(!$v->isValid(10), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsString\Exception");
        });

        it("returns false if value is 'string' and options have minLength => 10", function() {
            $v = new IsString();
            expect(!$v->isValid('string', ["minLength" => 10]), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsString\MinLength\Exception");
        });

        it("returns false if value is 'string' and options have maxLength => 1", function() {
            $v = new IsString();
            expect(!$v->isValid('string', ["maxLength" => 1]), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsString\MaxLength\Exception");
        });

        it("returns false if value is '    ' and options have notEmpty => true", function() {
            $v = new IsString();
            expect(!$v->isValid('  ', ["notEmpty" => true]), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsString\NotEmpty\Exception");
        });

        it("generates a correct error message", function() {
            $v = new IsString();
            $v->isValid(10);
            expect($v->getMessage())->to->equal("10 is not a string");
            $v->isValid("str", ["minLength" => 20]);
            expect($v->getMessage())->to->equal('"str" is too short; must be more than 20 chars');
            $v->isValid("str", ["maxLength" => 1]);
            expect($v->getMessage())->to->equal('"str" is too long; must be less than 1 chars');
            $v->isValid("  ", ["notEmpty" => true]);
            expect($v->getMessage())->to->equal('"  " string must not be empty or consist of whitespaces');
        });

    });
});

