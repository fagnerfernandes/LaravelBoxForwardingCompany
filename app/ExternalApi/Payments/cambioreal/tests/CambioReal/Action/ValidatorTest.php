<?php

/**
 * Validation class tests
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
class ValidatorTest extends TestCase {

    public function testExists()
    {
        $params = array('test' => 'yes');

        $validator = new \CambioReal\Action\Validator($params);
        $this->assertTrue($validator->exists('test'));
        $this->assertFalse($validator->exists('invalidParameter'));
    }

    public function testExistsNested()
    {
        $params = array(
            'level1' => 'yes',
            'level2'  => array(
                'test' => 'yes'
            ),
            'level3' => array(
                'test' => array(
                    'test' => 'yes'
                )
            )
        );

        $validator = new \CambioReal\Action\Validator($params);
        $this->assertTrue($validator->exists('level1'));
        $this->assertTrue($validator->exists('level2.test'));
        $this->assertTrue($validator->exists('level3.test.test'));
    }

    public function testValidateRequired()
    {
        $params = array('test' => 'yes');

        $validator = new \CambioReal\Action\Validator($params);

        $this->assertTrue($validator->required('test'));

        $this->setExpectedException('InvalidArgumentException', "The parameter 'foo' was not supplied.");
        $validator->required('foo');
    }

    public function testValidateRequiredOrNone()
    {
        $this->setExpectedException('InvalidArgumentException', "Either the parameter 'param1' or 'param2' must be supplied.");
        $validator = new \CambioReal\Action\Validator(array());
        $validator->requiredOne('param1', 'param2');
    }

    public function testValidateRequiredOrBoth()
    {
        $this->setExpectedException('InvalidArgumentException', "Either parameter 'param1' or 'param2' must be supplied, but not both.");
        $validator = new \CambioReal\Action\Validator(array('param1' => 1, 'param2' => 2));
        $validator->requiredOne('param1', 'param2');
    }

    public function testValidateRequiredOne()
    {
        $validator = new \CambioReal\Action\Validator(array('param1' => 1));
        $this->assertTrue($validator->requiredOne('param1', 'param2'));

        $validator = new \CambioReal\Action\Validator(array('param2' => 2));
        $this->assertTrue($validator->requiredOne('param1', 'param2'));
    }

}
