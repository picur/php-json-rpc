#
# SnagView - Servicelib Framework Build specifications
#

# norootforbuild

%define  basepath     /opt/snag-view/lib/php

#################

Name:           ##BUILD_NAME##
Version:        ##BUILD_VERSION##
Release:        ##BUILD_NUMBER##
Summary:        SNAG-View
Group:          SNAG-View
License:        other
Source:         %{name}-%{version}.tar.gz
BuildRoot:      %{_tmppath}/%{name}-%{version}-build
BuildArch:      x86_64
Packager:       frank.hildebrandt@sectornord.de

AutoReqProv:    no

provides:       snagview-framework-servicelib

%description

%prep
%setup -q

%build

%install
mkdir -p $RPM_BUILD_ROOT%{basepath}
mv src/* $RPM_BUILD_ROOT%{basepath}

%clean
rm -rf $RPM_BUILD_ROOT

%pre

%post

%postun

%files
%defattr(-,snagview,snagview,-)
%{basepath}

%changelog
