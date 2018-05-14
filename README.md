# com.jlacey.mailingtopic

Creates a workflow for mailing to specific emails for particular topics

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.4+
* CiviCRM 4.7.x, 5.0.x

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.jlacey.mailingtopic@https://github.com/josephlacey/com.jlacey.mailingtopic/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/josephlacey/com.jlacey.mailingtopic.git
cv en mailingtopic
```

## Usage

Create a location type for the $MAILING_TOPIC.  Include `[$MAILING_TOPIC]` in the email subject to use the mailing topic email address instead of primary or bulk.

## Known Issues

None at the moment but open Github issues
