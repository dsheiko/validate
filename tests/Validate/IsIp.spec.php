<?php
use Dsheiko\Validate\IsIp;

describe("\\Dsheiko\\Validate\\IsIp", function() {

    /**
     *  @covers Dsheiko\Validate\IsIp::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsIp();
            expect($v->isValid("127.0.0.1"))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if empty", function() {
            $v = new IsIp();
            expect(!$v->isValid("388.999"))->to->be->ok;
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsIp\Exception");
        });

    });
});

