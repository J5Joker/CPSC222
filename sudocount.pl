#!/usr/bin/perl

# Open the auth.log file
open my $fh, '<', '/var/log/auth.log' or die "Could not open file: '/var/log/auth.log'  $!";

my $count = 0;
while (my $line = <$fh>) {
    $count++ if $line =~ /pam_unix\(sudo:session\): session opened for user/;
}

print "$count\n";
close$fh;

