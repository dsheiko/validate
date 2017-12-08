<?php
use Dsheiko\Validate\IsEmailAddress;

describe("\\Dsheiko\\Validate\\IsEmailAddress", function() {

    /**
     *  @covers Dsheiko\Validate\IsEmailAddress::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsEmailAddress();
            expect($v->isValid("john.snow@got.org"))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if not a string", function() {
            $v = new IsEmailAddress();
            expect(!$v->isValid(1), "expected to be invalid");
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsEmailAddress\Exception");
        });

        it("returns false if empty", function() {
            $v = new IsEmailAddress();
            expect(!$v->isValid('  '), "expected to be invalid");
            expect($v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsEmailAddress\NotEmpty\Exception");
        });
        
        it("returns false if invalid email", function() {
            $v = new IsEmailAddress();
            $val = str_repeat("invalid@email.com", 3);
            expect(!$v->isValid($val), "expected to be invalid");
            expect($v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsEmailAddress\IsEmailAddress\Exception");
        });
    });
});

