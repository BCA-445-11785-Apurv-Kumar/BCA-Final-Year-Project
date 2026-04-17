<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* full height page */
        }
        .content {
            flex: 1; /* pushes footer down */
        }
    </style>
</head>

<body>
    <?php 
    include "dbconnect.php";
    include "partials/_header.php"; ?>
<div class="container my-5"> 
    <div class="row justify-content-center"> 
        <div class="col-lg-10"> 
            <h1 class="fw-bold mb-4 text-center">About iDiscuss</h1> 
            <p class="lead text-center mb-5"> iDiscuss is a community-driven discussion forum built for developers, learners, and technology enthusiasts to share knowledge, solve problems, and grow together. </p> 
            <!-- OUR STORY --> <section class="mb-5"> 
                <h3 class="fw-semibold mb-3">Our Story</h3> 
                <p> iDiscuss was created with a simple idea in mind — to provide a clean, friendly, and open platform where people can ask questions, share solutions, and discuss ideas related to programming and technology. </p> 
                <p> Many beginners struggle to find clear answers, while experienced developers often look for meaningful discussions. iDiscuss bridges this gap by encouraging collaboration, learning, and respectful conversation. </p>
             </section> <!-- OUR MISSION --> <section class="mb-5"> 
                <h3 class="fw-semibold mb-3">Our Mission</h3> 
                <ul> 
                    <li>To make technical knowledge accessible to everyone</li> 
                    <li>To encourage learning through discussion and collaboration</li> 
                    <li>To create a respectful and inclusive developer community</li>
                    <li>To support both beginners and experienced professionals</li> 
                </ul> </section> <!-- WHAT WE OFFER --> 
                <section class="mb-5"> 
                    <h3 class="fw-semibold mb-3">What We Offer</h3> 
                    <div class="row"> 
                        <div class="col-md-6 mb-3"> 
                            <div class="p-3 border rounded"> 
                                <h5>Discussion Categories</h5> 
                                <p class="mb-0"> Organized categories for programming languages, frameworks, web development, databases, and more. </p> 
                            </div> 
                        </div>
                         <div class="col-md-6 mb-3"> 
                            <div class="p-3 border rounded"> 
                                <h5>Threads & Comments</h5> <p class="mb-0"> Create threads, ask questions, and participate in meaningful discussions through comments. </p> 
                            </div> 
                        </div> 
                        <div class="col-md-6 mb-3"> <div class="p-3 border rounded"> 
                            <h5>User Accounts</h5> 
                            <p class="mb-0"> Registered users can post content, manage their activity, and build their presence in the community. </p> 
                        </div> 
                    </div> 
                    <div class="col-md-6 mb-3"> 
                        <div class="p-3 border rounded"> 
                            <h5>Admin Moderation</h5>
                             <p class="mb-0"> An admin panel ensures quality control, moderation, and a safe environment for everyone. </p>
                             </div> </div> </div> </section> <!-- COMMUNITY VALUES --> <section class="mb-5"> 
                                <h3 class="fw-semibold mb-3">Our Community Values</h3> 
                                <p> At iDiscuss, we believe that a strong community is built on respect, collaboration, and curiosity. We encourage users to: </p>
                                 <ul>
                                     <li>Ask questions without fear</li>
                                      <li>Help others by sharing knowledge</li>
                                       <li>Respect different opinions and skill levels</li>
                                        <li>Contribute positively and responsibly</li>
                                     </ul>
                                     </section> <!-- FUTURE VISION --> <section class="mb-5">
                                         <h3 class="fw-semibold mb-3">Our Vision for the Future</h3>
                                          <p> We aim to continuously improve iDiscuss by adding new features, enhancing performance, and expanding our community. </p>
                                           <p> In the future, we plan to introduce advanced search, reputation systems, better moderation tools, and more interactive learning experiences. </p>
                                         </section> <!-- CONTACT --> <section class="text-center mt-5"> <h4 class="fw-semibold mb-3">Get in Touch</h4>
                                          <p> Have suggestions, feedback, or questions? We’d love to hear from you. </p>
                                           <p> 📧 Email: <strong>support@idiscuss.com</strong><br> 🌍 Location: Hajipur, Vaishali, India </p>
                                         </section>
                                         </div>
                                         </div>
                                         </div>

    <?php include "partials/_footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
