![](https://www.sms77.io/wp-content/uploads/2019/07/sms77-Logo-400x79.png "sms77 Logo")

# sms77 for Contao Notification Center

## About

The package adds sms77 to the notification center as a gateway for sending SMS.

## Requirements

- [Contao 4](https://contao.org/)
- [Notification Center](https://github.com/terminal42/contao-notification_center)
- [sms77](https://www.sms77.io) account with an API key - can be created in
  your [developer dashboard](https://app.sms77.io/developer)

## Installation

1. Install via Contao Manager or
   Composer (`composer require sms77/contao-notification_center-sms77`)
2. Run a database update via the Contao install tool or using
   the [contao:migrate](https://docs.contao.org/dev/reference/commands/) command
3. Create a `SMS (sms77)` gateway in the Notification Center

## How to create an API key for sms77

1. Log in to the [sms77 dashboard](https://app.sms77.io/developer)
2. Click on the round green button with a plus shaped icon
3. Give it an appropriate label - e.g. `Primary` and click `Save`
5. Save the `Key` to the clipboard by clicking on the input

## Support

Need help? Feel free to [contact us](https://www.sms77.io/en/company/contact).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
