# Changelog 

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1] - 2021-01-31

### Added
- Recording Uptime
- Speedtest History Graph

### Changed
- Small UI Changes
- Fixed the Downlink Uplink Throughput Graph Bug.

### Removed


## [0.1] - 2021-01-30

### Added
- Obstructions can now be recorded for historical. $_CONFIG["record"]['obstructions'] = true;
- Obstructions can be downloaded in csv format.
- Playback the Obstruction.
- Added Pause Button
- Added Speedtest History and download CSV
- Added Mouseover Title Timestamp to Max Min Speeds (Desktop Browser only)

### Changed
- UI More Stable


### Removed


## [0.1] - 2021-01-29

### Added
- created INSTALLATION.md
- created CHANGELOG.md
- Display "Method" in info section.
- Modal to Display Help Notes (Click Info Icon next to Method to see it)
- Ramdisk Check (Requires mountpoint command to return w/ string containing "is not a mountpoint"
- Install Check (Makes sure data folder is world writeable and config file contains proper install directory)
- Graphs for throughput and latency using jQuery Sparklines

### Changed
- Obstruction Last 24 Hours. The percentage was being shown incorrectly. Now based on uptimeS or 24HoursInS. Whichever is less.
- Change Header Item Positioning

### Removed








