<?php
use Dsheiko\Validate\NotEmpty;

describe("\\Dsheiko\\Validate\\NotEmpty", function() {

    /**
     *  @covers Dsheiko\Validate\NotEmpty::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is a number", function() {
            $v = new NotEmpty();
            expect($v->isValid(1))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is a string", function() {
            $v = new NotEmpty();
            expect($v->isValid("str"), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is not empty array", function() {
            $v = new NotEmpty();
            expect($v->isValid([1]), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns true if value is not empty object", function() {
            $obj = (object) array("prop" => "val");
            $v = new NotEmpty();
            expect($v->isValid($obj), "expected to be valid");
            expect($v->getException())->to->equal(null);
        });

        it("returns false if value is null", function() {
            $v = new NotEmpty();
            expect(!$v->isValid(null), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\NotEmpty\Exception");
        });

        it("returns false if value is 0", function() {
            $v = new NotEmpty();
            expect(!$v->isValid(0), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\NotEmpty\Exception");
        });

        it("returns false if value is false", function() {
            $v = new NotEmpty();
            expect(!$v->isValid(false), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\NotEmpty\Exception");
        });

        it("returns false if value is empty string", function() {
            $v = new NotEmpty();
            expect(!$v->isValid(""), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\NotEmpty\Exception");
        });

        it("returns false if value is empty array", function() {
            $v = new NotEmpty();
            expect(!$v->isValid(""), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\NotEmpty\Exception");
        });

        it("generates a correct error message", function() {
            $v = new NotEmpty();
            $v->isValid(false);
            expect($v->getMessage())->to->equal('false is required and can\'t be empty');
        });

    });
});

