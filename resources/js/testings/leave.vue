<template>
    <div class="relative inline-block text-left">
        <div>
          <button type="button" class="flex items-center text-gray-600 focus:outline-none">
            <img src="profile-icon.png" alt="Profile Icon" class="w-8 h-8 rounded-full">
            <svg class="w-4 h-4 ml-2 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.293 6.293a1 1 0 011.414 0L10 7.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z"/><path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
          </button>
        </div>
        <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">View Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Logout</a>
          </div>
        </div>
      </div>

      In this example, we use the relative and inline-block classes for the containing div to position the dropdown. The profile icon and the dropdown are wrapped inside a div. The profile icon is an image with a circular shape (rounded-full) and a specified width and height.

      The dropdown content is within a nested div with the origin-top-right class to position it below the profile icon. The right-0 class aligns it to the right side, and the w-48 class sets the width of the dropdown.

      Within the dropdown, we have two a tags for "View Profile" and "Logout" options. These links have appropriate padding and styling for the menu items.

      Please note that you should replace "profile-icon.png" with the actual path to your profile icon image. Additionally, you can further customize the styles and appearance according to your project's design.

</template>
