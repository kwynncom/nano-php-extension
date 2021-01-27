# nano-php-extension
nanotime and TSC (CPU timestamp counter) for PHP

I link to x64 binaries below.

Purposes: 1. Rapidly create primary / unique keys, 2. nanosecond-precision time, 3. tools to try to correlate TSC and time

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
PURPOSE - ELABORATED

More specifically, for a true UUID, you'd need 

1. tsc, 2. pid, 
3. Any field that distinguishes one boot from another because TSC resets on boot - This can be a boot count, the time the batch started, Uns as above, etc.
4. A machine ID - See https://github.com/kwynncom/code-fragments/tree/9b25e60e8039aeaa5ba5dab6854e67e1f598437b
****************
BINARIES

https://kwynn.com/t/21/01/npk/

v0.0.15 - SHA256(2021_01_1_v0_0_15_nanopk.so)= a1bd5d0a0c5f7fd0d3af0859a5cf8308eea2d53b9501abce92956a90236cf1e2

*******
HISTORY

The first versions are at https://github.com/kwynncom/readable-primary-key/tree/5d6b839dbeba7b3b6355dcabe03a4d631aaf9b56  and earlier versions.

This needs its own repo, though.  This repo starts with version 0.0.15.

