# -*- coding: utf-8 -*-
# Generated by Django 1.11.1 on 2017-06-14 11:02
from __future__ import unicode_literals

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('personal', '0004_auto_20170614_1101'),
    ]

    operations = [
        migrations.AlterField(
            model_name='family',
            name='gened',
            field=models.CharField(max_length=50),
        ),
    ]