<?php
use Dsheiko\Validate\IsUrl;

describe("\\Dsheiko\\Validate\\IsUrl", function() {

    /**
     *  @covers Dsheiko\Validate\IsUrl::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsUrl();
            expect($v->isValid("https://www.google.com"))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if empty", function() {
            $v = new IsUrl();
            expect(!$v->isValid("google.com"))->to->be->ok;
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsUrl\Exception");
        });

    });
});

