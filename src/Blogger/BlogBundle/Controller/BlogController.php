<?php
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Blog;
use Blogger\BlogBundle\Form\BlogType;
use Symfony\Component\HttpFoundation\Request;


/**
 * Blog controller.
 */
class BlogController extends Controller
{
    /**
     * Show a blog entry
     */
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        $comments = $em->getRepository('BloggerBlogBundle:Comment')
                   ->getCommentsForBlog($blog->getId());
        

        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
    
    public function createAction(Request $request)
    {
        $post  = new Blog();
        $post->setBlog('Novo Post');
        $request = $this->getRequest();
        $form    = $this->createForm(new BlogType, $post);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getEntityManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_create', array(
                'id'    => $post->getBlog()->getId(),
                'slug'  => $post->getBlog()->getSlug())) 
            );
        }

        return $this->render('BloggerBlogBundle:Blog:create.html.twig', array(
            'post' => $post,
            'form'    => $form->createView()
        ));
    }
    
    protected function getBlog()
    {
        
    }
    
}
