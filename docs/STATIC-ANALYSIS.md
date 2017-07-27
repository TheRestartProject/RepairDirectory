# Static Analysis

A number of static analysis tools have been included as `dev` 
dependencies for this project. These can be run on the 
command-line to provide useful metrics and suggestions 
for code improvements. 

For ease of use, you can run the following tools with just one
command by using 

    composer run-script code

## Code Sniffing

> PHP_CodeSniffer is a set of two PHP scripts; the main phpcs 
script that tokenizes PHP, JavaScript and CSS files to detect 
violations of a defined coding standard, and a second phpcbf 
script to automatically correct coding standard violations. 
PHP_CodeSniffer is an essential development tool that 
ensures your code remains clean and consistent.

To run a Code Sniffing test across the project you can use 

    composer run-script sniff
    
## Mess Detection

> PHPMD is a spin-off project of PHP Depend and aims to be a 
PHP equivalent of the well known Java tool PMD. PHPMD can be 
seen as an user friendly frontend application for the raw 
metrics stream measured by PHP Depend.

To run a Mess Detection test across the project you can use

    composer run-script mess
    
## Copy-Paste Detection

> Duplicate code is almost always evidence of a design flaw. 
Therefore you should also check for duplicate code within 
your project. PHP Copy/Paste Detection 
(PHPCPD, https://github.com/sebastianbergmann/phpcpd) 
allows you to do just that.

You can run Copy-Paste Detection by using this command

    composer run-script copypaste
    
## Static Analysis (PHPStan)

> PHPStan focuses on finding errors in your code without actually 
running it. It catches whole classes of bugs even before you 
write tests for the code.
>
> PHPStan moves PHP closer to compiled languages in the sense that 
the correctness of each line of the code can be checked before 
you run the actual line.

To run Static Analysis across the project use

    composer run-script stan