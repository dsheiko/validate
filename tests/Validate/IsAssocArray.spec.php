<?php
use Dsheiko\Validate\IsAssocArray;

describe("\\Dsheiko\\Validate\\IsAssocArray", function() {

    /**
     *  @covers Dsheiko\Validate\IsAssocArray::isValid
     */
    describe('->isValid()', function() {

        it("returns true if value is valid", function() {
            $v = new IsAssocArray();
            expect($v->isValid(["foo" => 1, "bar" => 2]))->to->be->ok;
            expect($v->getException())->to->equal(null);
        });

        it("returns false if empty", function() {
            $v = new IsAssocArray();
            expect(!$v->isValid([1, 2, 3]))->to->be->ok;
            expect($v->getException())->to->be->an->instanceof("\\Dsheiko\Validate\IsAssocArray\Exception");
        });

    });
});

