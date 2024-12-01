<!-- resources/views/components/footer.blade.php -->
@props(['copyrightYear' => date('Y')])
<footer class="bg-white rounded-lg shadow flex items-center justify-center p-0 sm:p-1 xl:p-1 dark:bg-gray-200 antialiased fixed bottom-0 w-full">
   <p class="text-sm text-gray-500 dark:text-gray-400">
       &copy; {{ $copyrightYear }} <a href="https://ashtelgroup.com/" class="hover:underline" target="_blank">Ashtel</a>. All rights reserved.
   </p>
</footer>
