<?php
use Dsheiko\Validate\IsBool;

describe("\\Dsheiko\\Validate\\IsBool", function() {

    /**
     *  @covers Dsheiko\Validate\IsBool::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v1 = new IsBool();
            expect($v1->isValid(true))->to->be->ok;
            expect($v1->getException())->to->equal(null);
            $v2 = new IsBool();
            expect($v2->isValid(false), "expected to be valid");
            expect($v2->getException())->to->equal(null);
        });

        it("returns false if empty", function() {
            $v = new IsBool();
            expect(!$v->isValid(10))->to->be->ok;
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsBool\Exception");
        });
        
    });
});

