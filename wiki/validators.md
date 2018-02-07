# Implemented Validators

- IsAlnum - test if a supplied value is letters and digits only
    - [ notEmpty => {BOOLEAN} ]
- IsAlpha - test if a supplied value is letters only
    - [ notEmpty => {BOOLEAN} ]
- IsArray - test if a supplied value is an array
- IsAssocArray - test if a supplied value is a key-value array
- IsBool - test if a supplied value is a boolean
- IsCreditCard - test if a supplied value is a valid credit card number (Visa, America Express, JCB, Maestro, MasterCard, Solo, Switch)
- IsEmailAddress - test if a supplied value is an email address
    - [ notEmpty => {BOOLEAN} ]
- IsInt - test if a supplied value is an integer
    - [ max => {NUMBER} ]
    - [ min => {NUMBER} ]
- IsIp - test if a supplied value is a valid IP address
- IsMap - test if a supplied value complies map contract. See [Map Validation](./map-validation.md)
- IsString - test if a supplied value is a string
    - [ maxLength => {NUMBER} ]
    - [ minLength => {NUMBER} ]
    - [ notEmpty => {BOOLEAN} ]
- IsUrl - test if a supplied value is a valid URL
- IsUuid - test if a supplied value is a valid UUID v4
- NotEmpty -test if a supplied value is not nullable


* [Validator Chain](./validator-chain.md)