#!/usr/bin/perl
use strict;
use warnings;
use Crypt::Mac::HMAC qw( hmac hmac_hex );
print "please input password\n";

my $password = <>;


my $p = 23;
my $g =  5;
my $alpha = ($g**$password) % $p;
print "Alpha: $alpha \n";
print "Please enter two factor code:\n";
my $beta = <>;
my $K = ($beta**$password) % $p;

my $bin = sprintf ("%08b",$K);
my @bits = split(//,$bin);
print "$bin \n";
print "$K \n";

my $m = $alpha | $beta;
my $k1 = "";
my $k2 = "";
for (my $x = 0; $x <= 3; $x++) {
	$k1 = "$k1".$bits[$x];
}
$k2 = substr($bin, 4);
print "k1 = $k1 \n";
print "k2 = $k2 \n";
my $d = Crypt::Mac::HMAC->new('SHA256', $k1);
$d->add($m);
my$macCode = $d->hexmac;
print "HMAC = $macCode \n";
print "$m \n";