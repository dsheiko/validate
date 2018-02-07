<?php
use Dsheiko\Validate\IsUuid;

describe("\\Dsheiko\\Validate\\IsUuid", function() {

    /**
     *  @covers Dsheiko\Validate\IsUuid::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsUuid();
            expect($v->isValid("c9bf9e57-1685-4c89-bafb-ff5af830be8a"))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if empty", function() {
            $v = new IsUuid();
            expect(!$v->isValid("388.999"))->to->be->ok;
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsUuid\Exception");
        });

    });
});

