


<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite('resources/css/app.css')
  </head>
  <body class="flex flex-col items-center justify-center min-h-screen">
    <h1 class="text-3xl text-center font-bold underline centered m-4">
      Support Ticket Form
    </h1>

    <div class="m-4 p-4 border border-gray-300 rounded w-md justify-center">
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
     <form action="{{ route('form.data') }}" method="post" enctype="multipart/form-data" id="ticketForm" class="grid grid-rows-5">
        @csrf
        <div>
          <label for="name" class="block mb-1">Name:</label>
          <input type="text" id="name" name="name" class="border border-gray-300 rounded px-2 py-1 w-full">
        </div>
 <div>
  <label for="email" class="block mb-1">E-Mail:</label>
  <input type="text" id="email" name="email" class="border border-gray-300 rounded px-2 py-1 w-full">
  </div>

  <div>
  <label for="phone" class="block mb-1">Phone:</label>
  <input type="text" id="phone" name="phone" class="border border-gray-300 rounded px-2 py-1 w-full">
  </div>

  <div>
  <label for="message" class="block mb-1">Message:</label>
  <textarea id="message" name="message" rows="2" class="border border-gray-300 rounded px-2 py-1 w-full"></textarea>
  </div>

  <div>
  <label for="attachment" class="block mb-1">Attach:</label>
  <input type="file" id="attachment" name="attachment" class="border border-gray-300 rounded px-2 py-1 w-full">
  </div>

  <div>
  <input type="submit" value="Submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 cursor-pointer">
  </div>
</form>

</div>
  </body>
</html>


<script>
var form = document.getElementById("ticketForm");
form.reset();
</script>