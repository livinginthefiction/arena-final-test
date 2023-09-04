<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelTalk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <section class="bg-gray-60 min-h-screen flex items-center justify-center">
        <!-- login container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-md max-w-3xl p-5 items-center">
          <!-- form -->
          <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">PixelTalk</h2>
            

            <!-- Login Form -->
            <form method="post" action="<?= base_url('login/processLogin'); ?>" class="flex flex-col gap-4 signin">
            <p class="text-xs mt-2 text-[#002D74]">If you are already a member, easily log in here:</p>
              <input class="p-2 mt-0 rounded-md border" type="email" name="email" placeholder="Email">
              <div class="relative">
                <input class="p-2 rounded-md border w-full" type="password" name="password" placeholder="Password">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                </svg>
              </div>
              <button type="submit" class="bg-[#002D74] rounded-md text-white py-2 hover:opacity-80 duration-300" >Login</button>
            </form>

            <!-- Sign Up Form -->
            <form method="post" action="<?= base_url('login/processRegistration'); ?>" class="flex flex-col gap-4 signup">
                <p class="text-xs mt-2 text-[#002D74]">It won't needs 5 mins to be a member!</p>
                <input class="p-2 mt-2 rounded-md border" name="name" value="shubham" type="text" id="registerName" placeholder="Name">
                <input class="p-2 mt-2 rounded-md border" name="email" value="a@a.com" type="email" id="registerEmail" placeholder="Email">
              <div class="relative">
                <input class="p-2 rounded-md border w-full" type="password" name="password" placeholder="Password">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                </svg>
              </div>
              <button type="submit" class="bg-[#002D74] rounded-md text-white py-2 hover:opacity-80 duration-300">Sign In</button>
            </form>

            <div class="signup text-xs border-t border-[#002D74] py-2 flex justify-between items-center text-[#002D74]">
              <p>Already have an account?</p>
              <button id="tab-login" class="py-2 px-5 bg-white border rounded-md hover:bg-gray-200 duration-300">Login</button>
            </div>
      
            <div class="signin mt-3 text-xs border-t border-[#002D74] py-2 flex justify-between items-center text-[#002D74]">
              <p>Don't have an account?</p>
              <button id="tab-register" class="py-2 px-5 bg-white border rounded-md hover:bg-gray-200 duration-300">Register</button>
            </div>
          </div>
      
          <!-- image -->
          <div class="md:block hidden w-1/2">
            <img class="rounded-2xl h-[30rem]" src="https://images.pexels.com/photos/6193432/pexels-photo-6193432.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2">
          </div>
        </div>

        <div class="alert absolute bottom-10 right-3">
            <?php if (isset($validation)): ?>
            <div class="flex justify-between py-4 px-8 bg-[#fff2b2] text-[#7c620c]">
            <p class="font-sans"><?= $validation->listErrors() ?></p>
            <!-- <button class="font-bold ml-2">&#10005;</button> -->
            </div>
            <?php endif; ?>
        </div>
        <div class="alert absolute bottom-10 right-3">
            <?php if (isset($error)): ?>
            <div class="flex justify-between py-4 px-8 bg-[#ffe6d3] text-[#ff892f]">
            <p class="font-sans"><?= $error ?></p>
            <!-- <button class="font-bold ml-2">&#10005;</button> -->
            </div>
            <?php endif; ?>
        </div>
      </section>
  <script type="text/javascript">
    $(document).ready(function() {
      // Initially, hide the signup and show the signin
      $('.signup').hide();
      $('.signin').show();

      // When the "Show Sign Up" button is clicked
      $('#tab-register').click(function() {
          $('.signup').show();
          $('.signin').hide();
      });

      // When the "Show Sign In" button is clicked
      $('#tab-login').click(function() {
          $('.signin').show();
          $('.signup').hide();
      });
    });
  </script>    
</body>
</html>