<?php
use Dsheiko\Validate\IsAlpha;

describe("\\Dsheiko\\Validate\\IsAlpha", function() {

    /**
     *  @covers Dsheiko\Validate\IsAlpha::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsAlpha();
            expect($v->isValid("qwertyQWERTY"))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if not a string", function() {
            $v = new IsAlpha();
            expect(!$v->isValid(1), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsAlpha\Exception");
        });

        it("returns false if empty", function() {
            $v = new IsAlpha();
            expect(!$v->isValid('  '), "expected to be invalid");
            expect($v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsAlpha\NotEmpty\Exception");
        });

        it("returns false if invalid alpha", function() {
            $v = new IsAlpha();
            $val = "q1wer3ty";
            expect(!$v->isValid($val), "expected to be invalid");
            expect($v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsAlpha\IsAlpha\Exception");
        });
    });
});

