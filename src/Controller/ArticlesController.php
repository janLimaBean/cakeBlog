<?php 

namespace App\Controller;

class ArticlesController extends AppController
{
    public function initlialize()
    {
        $this->loadComponent('Flash'); // Include the FlashComponent for messages
    }

    public function index()
    {
        $articles = $this->Articles->find('all');
//NOTE ONLY USING THE PASSING VAR NAME AND NOT $articles BECAUSE WE CALLED $this.

/* compact() looks for a variable with that name in the current symbol table and adds it to the output array such that the variable name becomes the key and the contents of the variable become the value for that key. */
        $this->set(compact('articles'));

        //Shorthand for above
            //$this->set('articles', $this->Articles->find('all'));
    }

    public function view($id=null)
    {
/*We also do a bit of error checking to ensure a user is actually accessing a record. By using the get() function in the Articles table, we make sure the user has accessed a record that exists. In case the requested article is not present in the database, or the id is false the get() function will throw a NotFoundException.*/

        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if($this->request->is('post')){
//GETTING POST DATA
/*Every CakePHP request includes a Request object which is accessible using $this->request. The request object contains useful information regarding the request that was just received, and can be used to control the flow of your application. In this case, we use the Cake\Network\Request::is() method to check that the request is a HTTP POST request.

When a user uses a form to POST data to your application, that information is available in $this->request->getData(). You can use the pr() or debug() functions to print it out if you want to see what it looks like.*/

            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if($this->Articles->save($article)){
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        //render view with error Flash
        /* In the layout we have <?= $this->Flash->render() ?> which displays the message and clears the corresponding session variable.*/ 
        $this->set('article', $article);
    }

    public function edit($id=null)
    {
        $article = $this->Articles->get($id);
        if($this->request->is(['post','put'])){
            $this->Articles->patchEntity($article, $this->request->getData());
            if($this->Articles->save($article)){
                $this->Flash->success(__('Your Article has been updated'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('Your article has not been updated'));
        }
        $this->set('article',$article);
/*Next the action checks whether the request is either a POST or a PUT request. If it is, then we use the POST data to update our article entity by using the patchEntity() method. Finally we use the table object to save the entity back or kick back and show the user validation errors.*/
    }

    public function delete($id=null)
    {
/*If the user attempts to do a delete using a GET request, the allowMethod() will throw an Exception. Uncaught exceptions are captured by CakePHP’s exception handler, and a nice error page is displayed.*/
        $this->request->allowMethod(['post','delete']);

        $article = $this->Articles->get($id);
        if($this->Articles->delete($article)){
            $this->Flash->success(__('The article with id {0} has been deleted.',h($id)));
            return $this->redirect(['action'=>'index']);
        }
    }



} //end of ArticlesController
?>