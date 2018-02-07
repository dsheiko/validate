<?php
use Dsheiko\Validate\IsAlnum;

describe("\\Dsheiko\\Validate\\IsAlnum", function() {

    /**
     *  @covers Dsheiko\Validate\IsAlnum::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsAlnum();
            expect($v->isValid("qwertyQWERTY123"))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if not a string", function() {
            $v = new IsAlnum();
            expect(!$v->isValid(1), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsAlnum\Exception");
        });

        it("returns false if empty", function() {
            $v = new IsAlnum();
            expect(!$v->isValid('  '), "expected to be invalid");
            expect($v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsAlnum\NotEmpty\Exception");
        });

        it("returns false if invalid alpha", function() {
            $v = new IsAlnum();
            $val = "q1wer3ty.$";
            expect(!$v->isValid($val), "expected to be invalid");
            expect($v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsAlnum\IsAlnum\Exception");
        });
    });
});

