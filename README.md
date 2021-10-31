# nano-php-extension
nanotime and TSC (CPU timestamp counter) for PHP

I link to x64 binaries below.

Purposes: 1. Rapidly create primary / unique keys, 2. nanosecond-precision time, 3. tools to try to correlate TSC and time

VIEWING / READING / FORMAT NOTE: Newlines don't work well in HTML, so see the raw version (below) or download this file.

Raw version: https://raw.githubusercontent.com/kwynncom/nano-php-extension/main/README.md

******

Functions:

rdtscp() : returns associative array with 2 integer fields
    read (and return) 1. timestamp counter (tsc) and 2. processor ID (pid):
tsc - Number of CPU ticks (ie 2.3 GHz ticks) since boot
pid - the CPU / core / hyperthread that the "tick" / TSC came from - ranges from 0 to number of cores / hyperthreads - 1

nanotime() : returns integer - time as the number of nanoseconds in the UNIX Epoch

nanotime_array() : returns associative array with 2 integer fields
s  - number of seconds in the UNIX Epoch
ns - number of nanoseconds past s

nanopk() : returns assoc. array with 3 integers:

tsc as above
pid as above
Uns - as from nanotime()

nanopk(int $requestedFields) :  returns fields as defined by the argument, which is a bitmask defined by the constants in the .h file. 

nanopkavg() : in short the purpose is to get a Uns - TSC association to a known accuracy.  If you call this enough, you'll get 
    as accurate as possible


uptime() : various info on system uptime

**********
BUILDING

* Note: that if you are looking at this file on the web, you proably have to use the "raw" view to see newlines properly.  
* Note: I found that if I tried to simply "mv" the .so file, I had weird conflicts with PHP versions, and nanotime() and such were undefined.  
        So you may have to do all of these steps if you are replacing the .so rather than building it.

I'm going number the steps like old BASIC lines: 10, 20, etc...

STEP 05: 
Note that a prevous installation of this extension may confuse matters when you're trying to rebuild.  Your changes 
won't necessarily show up because PHP is still looking at the older version.  Best to disable the mod while devving:

sudo phpdismod nanopk

STEP 10:

I am assuming you are in the same directory as this project's build.sh, then:

bash build.sh

The result should be a PHP var_dump with working functions, ending in something like:
array(2) {
  ["s"]=>
  int(1625009669)
  ["ns"]=>
  int(409059072)
}
array(1) {
  ["nanopk_v"]=>
  string(5) "0.2.0"
}

STEP 20 (2 commands):
cd /tmp/npk
sudo make install

Resulting in (something like)
Installing shared extensions:     /usr/lib/php/20190902/

STEP 30:

Create a file with the following name with the following line.  The following commands are NOT the ones to create it but 
simply to show you what to create and where and what to call everything:

/etc/php/7.4/mods-available$ ls -l | grep nano
-rw-r--r-- 1 root root 21 Oct  6  2020 nanopk.ini
/etc/php/7.4/mods-available$ cat nanopk.ini
extension=nanopk.so

STEP 40:
sudo phpenmod nanopk

This creates 2 symbolic links:
lrwxrwxrwx 1 root root 38 Jun 29 19:46 20-nanopk.ini -> /etc/php/7.4/mods-available/nanopk.ini
in /etc/php/7.4/cli/conf.d
and it creates the same in 7.4/apache2

If you want to use it in Apache, you have to restart Apache.  This is a gentle restart:
sudo apachectl graceful


*************
PURPOSE - ELABORATED

More specifically, for a true UUID, you'd need 

1. tsc, 2. pid, 
3. Any field that distinguishes one boot from another because TSC resets on boot - This can be a boot count, the time the batch started, Uns as above, etc.
4. A machine ID - See https://github.com/kwynncom/code-fragments/tree/9b25e60e8039aeaa5ba5dab6854e67e1f598437b
****************
BINARIES

https://kwynn.com/t/21/01/npk/

v0.3.2
openssl sha512 /usr/lib/php/20200930/nanopk.so
SHA512(/usr/lib/php/20200930/nanopk.so)= f6a661bbc69e0dcb81da487a2df1217121bc343b50fc66158cd70b2b56a7f4467e49656317b1fa3030493cb620427d10b9774f824a0c73d601f7ccf746f3b84a
cp /usr/lib/php/20200930/nanopk.so /tmp
mv /tmp/nanopk.so /tmp/nanopk_v0_3_2_x86_64_for_PHP_v8_0_8_2021_1031_2_1745_EDT.so



v0.3.0
SHA512(/usr/lib/php/20200930/nanopk.so)= 6accdea832bfb749163c830c32197a9155fdc7e28fc5508f4e3061e80331548af4a69370359d8c43cdb7a2a8ba6b214d4cdbeda6823e8f68cf0b1ff1ba3bcb8f
renaming - no need to do this yourself.  I'm just keeping track of how I named it
cp /usr/lib/php/20200930/nanopk.so /tmp
mv /tmp/nanopk.so /tmp/nanopk_v0_3_0_x86_64_for_PHP_v8_0_8_2021_1031.so

Just confirming:

SHA512(/home/ubuntu/www/t/21/01/npk/nanopk_v0_3_0_x86_64_for_PHP_v8_0_8_2021_1031.so)= 6accdea832bfb749163c830c32197a9155fdc7e28fc5508f4e3061e80331548af4a69370359d8c43cdb7a2a8ba6b214d4cdbeda6823e8f68cf0b1ff1ba3bcb8f

*******

v0.2.0 is not different enough to bother with a new binary

v0.0.15:
SHA512(2021_01_1_v0_0_15_nanopk.so)= b1b454efeca7cf50d1123df9913911286e5fcb246ea469fe90e706dc3307c69256aa366dc31fa265cb4768fd854c60c8254ba8cb2c72e133f9628590f8989d9e
SHA256(2021_01_1_v0_0_15_nanopk.so)= a1bd5d0a0c5f7fd0d3af0859a5cf8308eea2d53b9501abce92956a90236cf1e2

*******
CREDITS / HELPFUL LINKS

https://www.seidengroup.com/2020/12/07/porting-extensions-to-php-8/

The following is useful but not ideally written:
https://www.phpinternalsbook.com/php7/extensions_design/php_functions.html


***************
POSSIBLE IMPROVEMENTS

I have found with recent (2021/06) experiments with pure C that making a library static (all code included rather than relying on 
dymanic linking) speeds things up by something like 10 - 15 us (microseconds).  I may try that some time.


************
HISTORY

The first versions are at https://github.com/kwynncom/readable-primary-key/tree/5d6b839dbeba7b3b6355dcabe03a4d631aaf9b56  and earlier versions.

This needs its own repo, though.  This repo starts with version 0.0.15.
********
GIT NOTES:

ssh mode: git remote set-url origin git@github.com:kwynncom/nano-php-extension

