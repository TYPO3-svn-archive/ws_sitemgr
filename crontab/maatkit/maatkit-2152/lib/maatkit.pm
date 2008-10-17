package maatkit;

our $VERSION = '2152';

1;

=pod

=head1 NAME

maatkit - Essential command-line utilities for MySQL.

=head1 DESCRIPTION

maatkit, formerly MySQL Toolkit, is a collection of command-line utilities that
provide missing functionality for MySQL.  Some of the tools implement lacking
server functionality, such as online consistency checks for master/slave
replication; others are client-side utilities such as a query profiler.

The following tools are included:

   $Revision: 2152 $
mk-archiver 1.0.10
mk-audit 0.9.1
mk-deadlock-logger 1.0.11
mk-duplicate-key-checker 1.1.7
mk-find 0.9.12
mk-heartbeat 1.0.10
mk-parallel-dump 1.0.9
mk-parallel-restore 1.0.8
mk-query-profiler 1.1.11
mk-show-grants 1.0.11
mk-slave-delay 1.0.8
mk-slave-find 1.0.2
mk-slave-move 0.9.2
mk-slave-prefetch 1.0.3
mk-slave-restart 1.0.8
mk-table-checksum 1.1.28
mk-table-sync 1.0.8
mk-visual-explain 1.0.9

=over


=item mk-archiver

Archive rows from a MySQL table into another table or a file. See L<mk-archiver>.

=item mk-audit

Analyze, summarize and report on MySQL config, schema and operation See L<mk-audit>.

=item mk-checksum-filter

Filter checksums from mk-table-checksum. See L<mk-checksum-filter>.

=item mk-deadlock-logger

Extract and log MySQL deadlock information. See L<mk-deadlock-logger>.

=item mk-duplicate-key-checker

Find possible duplicate indexes and foreign keys on
MySQL tables. See L<mk-duplicate-key-checker>.

=item mk-find

Find MySQL tables and execute actions, like GNU find. See L<mk-find>.

=item mk-heartbeat

Monitor MySQL replication delay. See L<mk-heartbeat>.

=item mk-parallel-dump

Dump sets of MySQL tables in parallel. See L<mk-parallel-dump>.

=item mk-parallel-restore

Load files into MySQL in parallel. See L<mk-parallel-restore>.

=item mk-profile-compact

Compact the output from mk-query-profiler. See L<mk-profile-compact>.

=item mk-query-profiler

Execute SQL statements and print statistics, or measure
activity caused by other processes. See L<mk-query-profiler>.

=item mk-show-grants

Canonicalize and print MySQL grants so you can effectively
replicate, compare and version-control them. See L<mk-show-grants>.

=item mk-slave-delay

Make a MySQL slave server lag behind its master. See L<mk-slave-delay>.

=item mk-slave-find

Find MySQL replication slaves and execute commands on them. See L<mk-slave-find>.

=item mk-slave-move

Move a MySQL slave around in the replication hierarchy. See L<mk-slave-move>.

=item mk-slave-prefetch

Pipeline relay logs on a MySQL slave to pre-warm caches. See L<mk-slave-prefetch>.

=item mk-slave-restart

Watch and restart MySQL replication after errors. See L<mk-slave-restart>.

=item mk-table-checksum

Perform an online replication consistency check, or
checksum MySQL tables efficiently on one or many servers. See L<mk-table-checksum>.

=item mk-table-sync

Synchronize MySQL tables efficiently. See L<mk-table-sync>.

=item mk-visual-explain

Format EXPLAIN output as a tree. See L<mk-visual-explain>.

=back

=head1 SEE ALSO

See also the L<maatkitdsn> documentation, which explains how to use DSNs to
connect to MySQL.

=head1 INSTALLATION

Strictly speaking these tools require no installation; you should be able to
run them stand-alone.  However, on UNIX-ish systems you can use the standard
Perl installation sequence:

   cd <package directory>
   perl Makefile.PL
   make install

=head1 SYSTEM REQUIREMENTS

You need Perl, DBI, DBD::mysql, and some core packages that ought to be
installed in any reasonably new version of Perl.

=head1 BUGS

If you find bugs, need features, etc please use the bug tracker, forums, and
mailing lists at http://code.google.com/p/maatkit/

=head1 COPYRIGHT, LICENSE AND WARRANTY

This program is copyright (c) 2007 Baron Schwartz and others.  Feedback and
improvements are welcome.

THIS PROGRAM IS PROVIDED "AS IS" AND WITHOUT ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE IMPLIED WARRANTIES OF
MERCHANTIBILITY AND FITNESS FOR A PARTICULAR PURPOSE.

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, version 2; OR the Perl Artistic License.  On UNIX and similar
systems, you can issue `man perlgpl' or `man perlartistic' to read these
licenses.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc., 59 Temple
Place, Suite 330, Boston, MA  02111-1307  USA.

=head1 AUTHOR

See the individual program's documentation for details.

=head1 VERSION

This manual page documents Distrib 2152 $Revision: 534 $.

=cut
