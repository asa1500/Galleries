<?php
use TypiCMS\Modules\Galleries\Models\Gallery;

class GalleriesControllerTest extends TestCase
{

    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/galleries');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = array(
            'en' => array(
                'status' => 1,
            )
        );
        $this->call('POST', 'admin/galleries', $input);
        $this->assertRedirectedToRoute('admin.galleries.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Gallery;
        $object->id = 1;
        Gallery::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test');
        $this->call('POST', 'admin/galleries', $input);
        $this->assertRedirectedToRoute('admin.galleries.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Gallery;
        $object->id = 1;
        Gallery::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test', 'exit' => true);
        $this->call('POST', 'admin/galleries', $input);
        $this->assertRedirectedToRoute('admin.galleries.index');
    }

}
