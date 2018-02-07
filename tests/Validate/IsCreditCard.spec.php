<?php
use Dsheiko\Validate\IsCreditCard;

describe("\\Dsheiko\\Validate\\IsCreditCard", function() {

    /**
     *  @covers Dsheiko\Validate\IsCreditCard::isValid
     */
    describe('->isValid()', function() {

        beforeEach(function (){
            $this->v = new IsCreditCard();
        });

        it("returns true if American Express", function() {
            expect($this->v->isValid("376562112896589"))->to->be->ok;
        });

        it("returns true if Visa", function() {
            expect($this->v->isValid("4716592591535490"))->to->be->ok;
        });

        it("returns true if Mastercard", function() {
            expect($this->v->isValid("5254866179512393"))->to->be->ok;
        });

        it("returns false if invalid alpha", function() {
            $val = "q1wer3tyww";
            expect(!$this->v->isValid($val), "expected to be invalid");
            expect($this->v->getException())->to->be->an
                ->instanceof("\\Dsheiko\Validate\IsCreditCard\Exception");
        });
    });
});

