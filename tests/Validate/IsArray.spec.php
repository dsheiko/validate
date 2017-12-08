<?php
use Dsheiko\Validate\IsArray;

describe("\\Dsheiko\\Validate\\IsArray", function() {

    /**
     *  @covers Dsheiko\Validate\IsArray::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsArray();
            expect($v->isValid([1]))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if empty", function() {
            $v = new IsArray();
            expect(!$v->isValid(10))->to->be->ok;
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsArray\Exception");
        });
        
    });
});

