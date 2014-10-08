<?php

namespace Nelmio\ApiDocBundle\Tests\Formatter;


use Nelmio\ApiDocBundle\Extractor\ApiDocExtractor;
use Nelmio\ApiDocBundle\Formatter\SwaggerFormatter;
use Nelmio\ApiDocBundle\Tests\WebTestCase;


/**
 * Class SwaggerFormatterTest
 *
 * @package Nelmio\ApiDocBundle\Tests\Formatter
 * @author Bez Hermoso <bez@activelamp.com>
 */
class SwaggerFormatterTest extends WebTestCase
{
    /**
     * @var ApiDocExtractor
     */
    protected $extractor;

    /**
     * @var SwaggerFormatter
     */
    protected $formatter;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $this->extractor = $container->get('nelmio_api_doc.extractor.api_doc_extractor');
        $this->formatter = $container->get('nelmio_api_doc.formatter.swagger_formatter');
    }


    public function testResourceListing()
    {

        set_error_handler(array($this, 'handleDeprecation'));
        $data = $this->extractor->all();
        restore_error_handler();

        /** @var $formatter SwaggerFormatter */

        $actual = $this->formatter->format($data, null);

        $expected = array(
            'swaggerVersion' => '1.2',
            'apiVersion' => '3.14',
            'info' =>
                array(
                    'title' => 'Nelmio Swagger',
                    'description' => 'Testing Swagger integration.',
                    'TermsOfServiceUrl' => 'https://github.com',
                    'contact' => 'user@domain.tld',
                    'license' => 'MIT',
                    'licenseUrl' => 'http://opensource.org/licenses/MIT',
                ),
            'authorizations' =>
                array(
                    'apiKey' => array(
                        'type' => 'apiKey',
                        'passAs' => 'header',
                        'keyname' => 'access_token',
                    )
                ),
            'apis' =>
                array(
                    array(
                        'path' => '/other-resources',
                        'description' => 'Operations on another resource.',
                    ),
                    array(
                        'path' => '/resources',
                        'description' => 'Operations on resource.',
                    ),
                    array(
                        'path' => '/tests',
                        'description' => NULL,
                    ),
                    array(
                        'path' => '/tests',
                        'description' => NULL,
                    ),
                    array(
                        'path' => '/tests2',
                        'description' => NULL,
                    ),
                    array(
                        'path' => '/TestResource',
                        'description' => NULL,
                    ),
                ),
        );

        $this->assertEquals($expected, $actual);


    }

    /**
     * @dataProvider dataTestApiDeclaration
     */
    public function testApiDeclaration($resource, $expected)
    {
        set_error_handler(array($this, 'handleDeprecation'));
        $data = $this->extractor->all();
        restore_error_handler();

        $actual = $this->formatter->format($data, $resource);

        $this->assertEquals($expected, $actual);

    }

    public function dataTestApiDeclaration()
    {
        return array(
            array(
                '/resources',
                array (
                    'swaggerVersion' => '1.2',
                    'apiVersion' => '3.14',
                    'basePath' => '/api',
                    'resourcePath' => '/resources',
                    'apis' =>
                        array (
                            0 =>
                                array (
                                    'path' => '/resources.{_format}',
                                    'operations' =>
                                        array (
                                            0 =>
                                                array (
                                                    'method' => 'GET',
                                                    'summary' => 'List resources.',
                                                    'nickname' => 'get_resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'code' => 200,
                                                                    'message' => 'Returned on success.',
                                                                    'responseModel' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test[tests]',
                                                                ),
                                                            1 =>
                                                                array (
                                                                    'code' => 404,
                                                                    'message' => 'Returned if resource cannot be found.',
                                                                ),
                                                        ),
                                                    'type' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test[tests]',
                                                ),
                                            1 =>
                                                array (
                                                    'method' => 'POST',
                                                    'summary' => 'Create a new resource.',
                                                    'nickname' => 'post_resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                            1 =>
                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'a',
                                                                    'type' => 'string',
                                                                    'description' => 'Something that describes A.',
                                                                ),
                                                            2 =>
                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'b',
                                                                    'type' => 'number',
                                                                    'format' => 'float',
                                                                ),
                                                            3 =>
                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'c',
                                                                    'type' => 'string',
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'x',
                                                                            1 => 'y',
                                                                            2 => 'z',
                                                                        ),
                                                                ),
                                                            4 =>
                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'd',
                                                                    'type' => 'string',
                                                                    'format' => 'date-time',
                                                                ),
                                                            5 =>
                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'e',
                                                                    'type' => 'string',
                                                                    'format' => 'date',
                                                                ),
                                                            6 =>
                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'g',
                                                                    'type' => 'string',
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'code' => 200,
                                                                    'message' => 'See standard HTTP status code reason for 200',
                                                                    'responseModel' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                                ),
                                                        ),
                                                    'type' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                ),
                                        ),
                                ),
                            1 =>
                                array (
                                    'path' => '/resources/{id}.{_format}',
                                    'operations' =>
                                        array (
                                            0 =>
                                                array (
                                                    'method' => 'GET',
                                                    'summary' => 'Retrieve a resource by ID.',
                                                    'nickname' => 'get_resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => 'id',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),
                                                            1 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),
                                            1 =>
                                                array (
                                                    'method' => 'DELETE',
                                                    'summary' => 'Delete a resource by ID.',
                                                    'nickname' => 'delete_resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => 'id',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),
                                                            1 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),
                                        ),
                                ),
                        ),
                    'models' =>
                        array (
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test',
                                    'description' => NULL,
                                    'properties' =>
                                        array (
                                            'a' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'b' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'DateTime',
                                                    'format' => 'date-time',
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                            0 => 'a',
                                        ),
                                ),
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test[tests]' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test[tests]',
                                    'description' => '',
                                    'properties' =>
                                        array (
                                            'tests' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => NULL,
                                                    'items' =>
                                                        array (
                                                            '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.Test',
                                                        ),
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                            0 => 'tests',
                                        ),
                                ),
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest',
                                    'description' => 'object (JmsTest)',
                                    'properties' =>
                                        array (
                                            'foo' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'bar' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'DateTime',
                                                    'format' => 'date-time',
                                                ),
                                            'number' =>
                                                array (
                                                    'type' => 'number',
                                                    'description' => 'double',
                                                    'format' => 'float',
                                                ),
                                            'arr' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => 'array',
                                                    'items' =>
                                                        array (
                                                            'type' => 'string',
                                                        ),
                                                ),
                                            'nested' =>
                                                array (
                                                    '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                ),
                                            'nested_array' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => 'array of objects (JmsNested)',
                                                    'items' =>
                                                        array (
                                                            '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                        ),
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                        ),
                                ),
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                    'description' => '',
                                    'properties' =>
                                        array (
                                            'foo' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'DateTime',
                                                    'format' => 'date-time',
                                                ),
                                            'bar' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'baz' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => 'Epic description.

With multiple lines.',
                                                    'items' =>
                                                        array (
                                                                'type' => 'integer',
                                                        ),
                                                ),
                                            'circular' =>
                                                array (
                                                    '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                ),
                                            'parent' =>
                                                array (
                                                    '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest',
                                                ),
                                            'since' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'until' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'since_and_until' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                        ),
                                ),
                        ),
                    'produces' =>
                        array (
                        ),
                    'consumes' =>
                        array (
                        ),
                    'authorizations' =>
                        array (
                            'apiKey' =>
                                array (
                                    'type' => 'apiKey',
                                    'passAs' => 'header',
                                    'keyname' => 'access_token',
                                ),
                        ),
                ),
            ),
            array(
                '/other-resources',
                array (
                    'swaggerVersion' => '1.2',
                    'apiVersion' => '3.14',
                    'basePath' => '/api',
                    'resourcePath' => '/other-resources',
                    'apis' =>
                        array (
                            0 =>
                                array (
                                    'path' => '/other-resources.{_format}',
                                    'operations' =>
                                        array (
                                            0 =>
                                                array (
                                                    'method' => 'GET',
                                                    'summary' => 'List another resource.',
                                                    'nickname' => 'get_other-resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'code' => 200,
                                                                    'message' => 'See standard HTTP status code reason for 200',
                                                                    'responseModel' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest[]',
                                                                ),
                                                        ),
                                                    'type' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest[]',
                                                ),
                                        ),
                                ),
                            1 =>
                                array (
                                    'path' => '/other-resources/{id}.{_format}',
                                    'operations' =>
                                        array (
                                            0 =>
                                                array (
                                                    'method' => 'PUT',
                                                    'summary' => 'Update a resource bu ID.',
                                                    'nickname' => 'put_other-resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => 'id',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),
                                                            1 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),
                                            1 =>
                                                array (
                                                    'method' => 'PATCH',
                                                    'summary' => 'Update a resource bu ID.',
                                                    'nickname' => 'patch_other-resources',
                                                    'parameters' =>
                                                        array (
                                                            0 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => 'id',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),
                                                            1 =>
                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                    'enum' =>
                                                                        array (
                                                                            0 => 'json',
                                                                            1 => 'xml',
                                                                            2 => 'html',
                                                                        ),
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),
                                        ),
                                ),
                        ),
                    'models' =>
                        array (
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest',
                                    'description' => NULL,
                                    'properties' =>
                                        array (
                                            'foo' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'bar' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'DateTime',
                                                    'format' => 'date-time',
                                                ),
                                            'number' =>
                                                array (
                                                    'type' => 'number',
                                                    'description' => 'double',
                                                    'format' => 'float',
                                                ),
                                            'arr' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => 'array',
                                                    'items' =>
                                                        array (
                                                            'type' => 'string',
                                                        ),
                                                ),
                                            'nested' =>
                                                array (
                                                    '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                ),
                                            'nested_array' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => 'array of objects (JmsNested)',
                                                    'items' =>
                                                        array (
                                                            '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                        ),
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                        ),
                                ),
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                    'description' => 'object (JmsNested)',
                                    'properties' =>
                                        array (
                                            'foo' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'DateTime',
                                                    'format' => 'date-time',
                                                ),
                                            'bar' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'baz' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => 'Epic description.

With multiple lines.',
                                                    'items' =>
                                                        array (
                                                            'type' => 'integer',
                                                        ),
                                                ),
                                            'circular' =>
                                                array (
                                                    '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsNested',
                                                ),
                                            'parent' =>
                                                array (
                                                    '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest',
                                                ),
                                            'since' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'until' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                            'since_and_until' =>
                                                array (
                                                    'type' => 'string',
                                                    'description' => 'string',
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                        ),
                                ),
                            'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest[]' =>
                                array (
                                    'id' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest[]',
                                    'description' => '',
                                    'properties' =>
                                        array (
                                            '' =>
                                                array (
                                                    'type' => 'array',
                                                    'description' => NULL,
                                                    'items' =>
                                                        array (
                                                            '$ref' => 'Nelmio.ApiDocBundle.Tests.Fixtures.Model.JmsTest',
                                                        ),
                                                ),
                                        ),
                                    'required' =>
                                        array (
                                            0 => '',
                                        ),
                                ),
                        ),
                    'produces' =>
                        array (
                        ),
                    'consumes' =>
                        array (
                        ),
                    'authorizations' =>
                        array (
                            'apiKey' =>
                                array (
                                    'type' => 'apiKey',
                                    'passAs' => 'header',
                                    'keyname' => 'access_token',
                                ),
                        ),
                ),
            ),
            array(
                '/tests',
                array (
                    'swaggerVersion' => '1.2',
                    'apiVersion' => '3.14',
                    'basePath' => '/api',
                    'resourcePath' => '/tests',
                    'apis' =>
                        array (

                                array (
                                    'path' => '/tests.{_format}',
                                    'operations' =>
                                        array (

                                                array (
                                                    'method' => 'GET',
                                                    'summary' => 'index action',
                                                    'nickname' => 'get_tests',
                                                    'parameters' =>
                                                        array (

                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),
                                                                array (
                                                                    'paramType' => 'query',
                                                                    'name' => 'a',
                                                                    'type' => 'integer',
                                                                    'description' => null,
                                                                ),
                                                                array (
                                                                    'paramType' => 'query',
                                                                    'name' => 'b',
                                                                    'type' => 'string',
                                                                    'description' => null,
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),

                                                array (
                                                    'method' => 'GET',
                                                    'summary' => 'index action',
                                                    'nickname' => 'get_tests',
                                                    'parameters' =>
                                                        array (

                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),

                                                                array (
                                                                    'paramType' => 'query',
                                                                    'name' => 'a',
                                                                    'type' => 'integer',
                                                                    'description' => null,
                                                                ),

                                                                array (
                                                                    'paramType' => 'query',
                                                                    'name' => 'b',
                                                                    'type' => 'string',
                                                                    'description' => null,
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),

                                                array (
                                                    'method' => 'POST',
                                                    'summary' => 'create test',
                                                    'nickname' => 'post_tests',
                                                    'parameters' =>
                                                        array (

                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'a',
                                                                    'type' => 'string',
                                                                    'description' => 'A nice description',
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'b',
                                                                    'type' => 'string',
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'c',
                                                                    'type' => 'boolean',
                                                                    'defaultValue' => false,
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'd',
                                                                    'type' => 'string',
                                                                    'defaultValue' => 'DefaultTest',
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),

                                                array (
                                                    'method' => 'POST',
                                                    'summary' => 'create test',
                                                    'nickname' => 'post_tests',
                                                    'parameters' =>
                                                        array (

                                                                array (
                                                                    'paramType' => 'path',
                                                                    'name' => '_format',
                                                                    'type' => 'string',
                                                                    'required' => true,
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'a',
                                                                    'type' => 'string',
                                                                    'description' => 'A nice description',
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'b',
                                                                    'type' => 'string',
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'c',
                                                                    'type' => 'boolean',
                                                                    'defaultValue' => false,
                                                                ),

                                                                array (
                                                                    'paramType' => 'form',
                                                                    'name' => 'd',
                                                                    'type' => 'string',
                                                                    'defaultValue' => 'DefaultTest',
                                                                ),
                                                        ),
                                                    'responseMessages' =>
                                                        array (
                                                        ),
                                                ),
                                        ),
                                ),
                        ),
                    'models' =>
                        array (
                        ),
                    'produces' =>
                        array (
                        ),
                    'consumes' =>
                        array (
                        ),
                    'authorizations' =>
                        array(
                            'apiKey' => array(
                                'type' => 'apiKey',
                                'passAs' => 'header',
                                'keyname' => 'access_token',
                            )
                        ),
                ),
            ),
        );
    }
}