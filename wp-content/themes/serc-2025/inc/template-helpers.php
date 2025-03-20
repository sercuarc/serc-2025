<?php

/**
 * Template Helpers
 * A collection of helper functions for use in templates
 */

function serc_svg($name)
{
	$icons = [
		'check-circle' => '<svg id="check-circle" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8Z" fill="currentColor" /><path d="M4.5 7.5L7.5 10.5L11.5 5" stroke="white" stroke-width="2" /</svg>',
		'chevron-down' => '<svg id="chevron-down" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.792969 5.20706L2.20718 3.79285L8.00008 9.58574L13.793 3.79285L15.2072 5.20706L8.00008 12.4142L0.792969 5.20706Z" fill="currentColor" /></svg>',
		'chevron-up' => '<svg id="chevron-up" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.792969 11L2.20718 12.4142L8.00008 6.62129L13.793 12.4142L15.2072 11L8.00008 3.79286L0.792969 11Z" fill="currentColor" /></svg>',
		'exclamation-circle' => '<svg id="exclamation-circle" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16ZM6.83881 3.54547H9.16089L8.94854 10.1055H7.05116L6.83881 3.54547ZM9.20244 11.9336C9.19321 12.5984 8.63461 13.1339 8.00216 13.1339C7.33738 13.1339 6.79264 12.5984 6.80187 11.9336C6.79264 11.2781 7.33738 10.7472 8.00216 10.7472C8.63461 10.7472 9.19321 11.2781 9.20244 11.9336Z" fill="currentColor" /></svg>',
		'lock' => '<svg id="lock" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.66667V4C12 1.79133 10.2087 0 8 0C5.79133 0 4 1.79133 4 4V6.66667H2V16H14V6.66667H12ZM8.66667 11.8153V13.3333H7.33333V11.8153C6.93667 11.584 6.66667 11.1593 6.66667 10.6667C6.66667 9.93067 7.264 9.33333 8 9.33333C8.736 9.33333 9.33333 9.93067 9.33333 10.6667C9.33333 11.1587 9.064 11.584 8.66667 11.8153ZM5.33333 4V6.66667H10.6667V4C10.6667 2.52933 9.47 1.33333 8 1.33333C6.52933 1.33333 5.33333 2.52933 5.33333 4Z" fill="currentColor" /></svg>',
	];
	return isset($icons[$name]) ? $icons[$name] : "";
}
