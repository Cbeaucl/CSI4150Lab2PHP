#!/usr/bin/perl
use strict;
use warnings;

print "please input password\n";

my $password = <>;
print "Please enter two factor code:\n";
my $beta = <>;
my $p = 23;
my $g =  5;
my $mathThing = ($beta**$password) % $p;
print "$mathThing";